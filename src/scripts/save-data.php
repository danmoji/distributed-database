<?php

declare(strict_types=1);
require_once '../classes/Note.class.php';
require_once '../classes/Queue.class.php';
require_once '../classes/Api.class.php';

$nodes = json_decode(file_get_contents('../nodes-list.JSON'), true)['nodes'];
$noteTitle = $_POST['note_title'];
$noteDescription = $_POST['note_description'];
$noteKeyHash = substr(md5(openssl_random_pseudo_bytes(20)), -32);
$creatorNodeName = $_ENV['HOST_NAME'];

$noteData = [
  'note_title' => $noteTitle,
  'note_description' => $noteDescription,
  'note_key_hash' => $noteKeyHash,
  'creator_node_name' => $creatorNodeName,
];

$note = new Note($noteData);
$note->saveNote();

$filteredNodes = array_filter($nodes, function($node) use ($hostNode) {
  return $node !== $hostNode;
});
