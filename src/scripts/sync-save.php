<?php

declare(strict_types=1);
require_once '../classes/Note.class.php';

//TODO rename to sync data 

//TODO if statement in the beginning that looks up the sql method

//if($_POST['mehod'] is not set then save)
//if($_POST['mehod'] === 'delete' then delete)
//if($_POST['mehod'] === 'update' then update)

$method = $_POST['method'];
$note = new Note($_POST);

if(isNotSet($method)) {
  $note->saveNote();
  echo 'OK from other node and Note is saved <';
  die();
} else if($method === 'update') {
  $note->updateNote();
} else if($method === 'delete') {
  $note->deleteNote();
} else {
  throw new Exception('Invalid method in POST params!');
}







function isNotSet(string $method): bool {
  return !isset($method);
}