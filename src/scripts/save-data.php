<?php

declare(strict_types=1);
require_once '../classes/Note.class.php';
require_once '../classes/Queue.class.php';
require_once '../classes/Api.class.php';
require_once '../classes/Synchronization.class.php';


$note = new Note($_POST);
$note->saveNote();
$noteData = $note->getNoteData();

$queue = new Queue();
$queue->saveUnsyncedNotes($noteData);

$sync  = new Synchronization();

$sync->syncAll();


//TODO krok 3 vyber vsetky query pre uzol naraz uzla a odosli ich na ostatne uzly

//ak je uspesne tak vymaz ju z queue

//ak nie je tak skus dalsi uzol

header("Location: http://" . $_ENV["HOST_ADRESS"] . ':' . $_ENV["HOST_PORT"]);
die();
