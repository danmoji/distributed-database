<?php

declare(strict_types=1);
require_once '../classes/Note.class.php';
require_once '../classes/Queue.class.php';
require_once '../classes/Api.class.php';
require_once '../classes/Synchronization.class.php';


print_r($_POST);
die();
$note = new Note($_POST);
$note->saveNote();


header("Location: http://" . $_ENV["HOST_ADRESS"] . ':' . $_ENV["HOST_PORT"]);
die();
