<?php

declare(strict_types=1);

require_once '../classes/Api.class.php';
require_once '../classes/Note.class.php';
require_once '../classes/Queue.class.php';

$isSyncStage = isset($_POST['sync_stage']) ? true : false; //TODO rework

$nodes = json_decode(file_get_contents('../nodes-list.JSON'), true)['nodes'];
$noteTitle = isset($_POST['note_title']) ? $_POST['note_title'] : 'random name was created'; //TODO add validation
$noteDescription = isset($_POST['note_description']) ? $_POST['note_description'] : 'random name was created'; //TODO add validation
$hostNode = $_ENV['HOST_NAME'];
$creatorNodeName = isset($_POST['creator_node_name']) ? $_POST['creator_node_name'] : $hostNode;
$creatorNodeKey = isset($_POST['creator_node_key']) ? $_POST['creator_node_key'] : substr(md5(openssl_random_pseudo_bytes(20)), -32);

$filteredNodes = array_filter($nodes, function ($node) use ($hostNode) {
  return $node !== $hostNode;
});

$note = new Note();
$note->create($noteTitle, $noteDescription, $creatorNodeName, $creatorNodeKey);

foreach ($filteredNodes as $distantNodeAdress) {
  createUnsyncedQuery($noteTitle, $noteDescription, $creatorNodeName, $creatorNodeKey, $distantNodeAdress);
  $queue = new Queue();
  $queue->deleteSyncedQuery($distantNodeAdress, $creatorNodeKey);
}

foreach ($filteredNodes as $distantNodeAdress) {
  $data = $queue->selectAllUnsyncedQueries($distantNodeAdress);
  foreach ($data as $row) {
    sendUnsyncedQuery($row, $distantNodeAdress);
  }
}

function sendUnsyncedQuery($row, $distantNodeAdress)
{
  $url = "http://" . $distantNodeAdress . "/save-data.php";

  $payload = [
    'note_title' => $row['note_title'],
    'note_description' => $row['note_description'],
    'creator_node_name' => $row['creator_node_name'],
    'creator_node_key' => $row['creator_node_key']
  ];

  $api = new Api();
  $api->post($url, $payload);
}

function createUnsyncedQuery(string $noteTitle, string $noteDescription, string $creatorNodeName, string $creatorNodeKey, string $distantNodeAdress)
{
  $queue = new Queue();
  $queue->createUnsyncedQuery($noteTitle, $noteDescription, $creatorNodeName, $creatorNodeKey, $distantNodeAdress);
}

header("Location: http://" . $_ENV["HOST_ADRESS"] . ':' . $_ENV["HOST_PORT"]);
die();
