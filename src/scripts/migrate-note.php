<?php

require_once("../classes/NoteController.class.php");
require_once("../classes/Redirect.class.php");

$noteController = new NoteController();
$noteController->migrateNote();

$redirect = new Redirect();
$redirect->homeAndDie();
 