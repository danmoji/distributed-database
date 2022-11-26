<?php

require_once ("../classes/Note.class.php");

$note  = new Note();
$notes = $note->migrate();

header("Location: http://" . $_ENV["HOST_ADRESS"] . ':' . $_ENV["HOST_PORT"]);

die();