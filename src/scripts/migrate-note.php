<?php

require_once("../classes/Note.class.php");
require_once("../classes/Redirect.class.php");

$note  = new Note();
$note->migrate();

$redirect = new Redirect();
$redirect->homeAndDie();
