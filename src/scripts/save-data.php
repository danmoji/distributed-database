<?php

declare(strict_types=1);

require_once '../classes/Note.class.php';
require_once '../classes/Queue.class.php';
require_once '../classes/Api.class.php';
require_once '../classes/Nodes.class.php';
require_once '../classes/SyncData.class.php';
require_once '../classes/Redirect.class.php';

$note = new Note($_POST);
$queue = new Queue();
$syncData = new SyncData();
$method = $_POST['method'];

if ($method === "save") {
  $note->saveNote();
} else if ($method === "update") {
  $note->updateNote();
} else if($method === "delete") {
  $note->deleteNote();
} else {
  throw new Exception('Undefined method given!');
}

$noteData = $note->getNoteData();
$queue->saveUnsyncedNote($noteData);
$syncData->syncAll();

$redirect = new Redirect();
$redirect->homeAndDie();