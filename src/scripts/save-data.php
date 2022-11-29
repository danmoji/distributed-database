<?php

declare(strict_types=1);

require_once '../classes/Note.class.php';
require_once '../classes/Queue.class.php';
require_once '../classes/Api.class.php';
require_once '../classes/Nodes.class.php';

$nodes = new Nodes();
$filteredNodeAdresses = $nodes->filteredNodes;
$host = $_ENV['HOST_ADRESS'] | '';

$note = new Note($_POST);
$note->saveNote();
$noteData = $note->getNoteData();

$queue = new Queue();
$queue->saveUnsyncedNote($noteData);

syncAll($filteredNodeAdresses, $queue);

function syncAll($filteredNodeAdresses, $queue): void
{
  $nodeAdresses = $filteredNodeAdresses;
  if(!$nodeAdresses) throw new Exception('Node adresses not definded!');
  foreach ($nodeAdresses as $nodeAdress) {
    $dataToSync = $queue->selectAllUnsyncedQueriesOfOneDistatnNode($nodeAdress);
    $url = "http://" . $nodeAdress . '/scripts/sync-save.php';
    foreach ($dataToSync as $payload) {
      $response = sync($url, $payload);

      if($response)

       $queue->deleteSyncedQuery($payload['distant_node_adress'], $payload['note_hash_key']);
    }
  }
  
}

function sync(string $url, array $payload): string|false
{
  try {
    $response = Api::post($url, $payload);
  } catch (Exception $error) {
    echo '<pre>';
    print_r($error->getMessage() . ' in file: ' . $error->getFile() . ' on line: ' . $error->getLine());
    echo '</pre>';
    die();
  }
  return $response;
}

header("Location: http://" . $_ENV["HOST_ADRESS"] . ':' . $_ENV["HOST_PORT"]);
die();