<?php

require_once('classes/Note.class.php');

$note = new Note();
$notes = $note->selectAll();

foreach($notes as $note)
  print_r($note);