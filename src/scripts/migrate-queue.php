<?php

require_once("../classes/QueueController.class.php");
require_once("../classes/Redirect.class.php");

$queueController = new QueueController();
$queueController->migrateQueue();

$redirect = new Redirect();
$redirect->homeAndDie();
