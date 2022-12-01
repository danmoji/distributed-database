<?php

declare(strict_types=1);
require_once '../classes/NoteController.class.php';

$method = $_POST['method'];
$noteController = new NoteController($_POST);

if ($method === 'save') {
  $noteController->saveNote();
} else if ($method === 'update') {
  $noteController->updateNote();
} else if ($method === 'delete') {
  $noteController->deleteNote();
} else {
  //TODO need to return other than 200 probably
  echo 'Invalid method in POST params!';
}
