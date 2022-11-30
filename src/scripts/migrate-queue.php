<?php

require_once("../classes/Queue.class.php");
require_once("../classes/Redirect.class.php");

$queue = new Queue();
$queue->migrate();

$redirect = new Redirect();
$redirect->homeAndDie();
