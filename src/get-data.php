<?php declare(strict_types=1);

//TODO set env variable instead of http://localhost:8101
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ' . 'http://localhost:8101');
  die();
};

require('./Person.class.php');

$name = $_POST['name'];

$mike = new Person($name);

echo 'Hello ' . $mike->getName() . '!';