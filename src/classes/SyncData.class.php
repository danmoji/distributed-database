<?php

declare(strict_types=1);

require_once 'Api.class.php';
require_once 'Nodes.class.php';
require_once 'Queue.class.php';
require_once 'HandleException.class.php';
class SyncData
{
  private Nodes $nodes;
  private Queue $queue;
  private array $filteredNodeAdresses;
  private HandleException $handleException;

  public function __construct()
  {
    $this->queue = new Queue();
    $this->nodes = new Nodes();
    $this->handleException = new HandleException();
    $this->filteredNodeAdresses = $this->nodes->filteredNodes;
  }

  public function syncAll(): void
  {
    $nodeAdresses = $this->filteredNodeAdresses;
    if (!$nodeAdresses) throw new Exception('Node adresses not definded!');
    foreach ($nodeAdresses as $nodeAdress) {
      $dataToSync = $this->queue->selectAllUnsyncedQueriesOfOneDistatnNode($nodeAdress);
      $url = "http://" . $nodeAdress . '/scripts/sync-save.php';
      foreach ($dataToSync as $payload) {
        $response = $this->sync($url, $payload);
        if ($response)
          $this->queue->deleteSyncedQuery($payload['distant_node_adress'], $payload['note_hash_key']);
      }
    }
  }

  private function sync(string $url, array $payload): string|false
  {
    try {
      $response = Api::post($url, $payload);
    } catch (Exception $e) {
      $this->handleException->formatAndPrint($e);
    }
    return $response;
  }
}
