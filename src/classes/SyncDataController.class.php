<?php

declare(strict_types=1);

require_once 'Api.class.php';
require_once 'Nodes.class.php';
require_once 'Queue.class.php';
require_once 'HandleException.class.php';
class SyncDataController
{
  private Nodes $nodes;
  private HandleException $handleException;
  private Api $api;

  public function __construct()
  {
    $this->api = new Api();
    $this->nodes = new Nodes();
    $this->handleException = new HandleException();
  }

  public function syncAllNotes(array $dataToSync): array
  {
    $successfullySyncedQueries = [];
    foreach ($this->nodes->filteredNodes as $nodeAdress) {
      foreach ($dataToSync as $payload) {
       $response = $this->sync($nodeAdress, $payload);
       if($response)
        array_push($successfullySyncedQueries, 
          [$payload['distant_node_adress'], $payload['note_hash_key']]
        );
      }
    }
    return $successfullySyncedQueries;
  }

  private function sync(string $nodeAdress, array $payload): bool
  {
    $url = "http://" . $nodeAdress . '/scripts/sync-save.php';
    try {
      $response = $this->api->post($url, $payload);
    } catch (Exception $e) {
      $this->handleException->formatAndPrint($e);
    }
    return $response;
  }
}
