<?php

require_once("../classes/Queue.class.php");

$queue = new Queue();
$queue->migrate();

header("Location: http://" . $_ENV["HOST_ADRESS"] . ':' . $_ENV["HOST_PORT"]);
die();