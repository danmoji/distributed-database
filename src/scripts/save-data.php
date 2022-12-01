<?php

declare(strict_types=1);

require_once '../classes/NoteController.class.php';
require_once '../classes/QueueController.class.php';
require_once '../classes/SyncDataController.class.php';
require_once '../classes/Redirect.class.php';


$method = $_POST['method'];
$noteController = new NoteController($_POST);
$queueController = new QueueController();
$syncDataController = new SyncDataController();

if ($method === "save") {
  $noteController->saveNote();
} else if ($method === "update") {
  $noteController->updateNote();
} else if ($method === "delete") {
  $noteController->deleteNote();
} else {
  throw new Exception('Undefined method given: ' . $method);
}

$noteData = $noteController->getCurrentNoteData();
$queueController->saveUnsyncedNote($noteData);
$dataToSync = $queueController->fetchAllNotes();
$syncedNotes = $syncDataController->syncAllNotes($dataToSync);
$queueController->deleteAllSyncedNotes($syncedNotes);

$redirect = new Redirect();
$redirect->homeAndDie();