<?php

declare(strict_types=1);
require_once '../classes/Note.class.php';

$method = $_POST['method'];
$note = new Note($_POST);

if ($method === 'save') {
  $note->saveNote();
  echo 'OK from other node and Note is saved!';
} else if ($method === 'update') {
  $note->updateNote();
  echo 'OK from other node and Note is updated!';
} else if ($method === 'delete') {
  $note->deleteNote();
  echo 'OK from other node and Note is deleted!';
} else {
  echo 'Invalid method in POST params!';
}
