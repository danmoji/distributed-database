<?php declare(strict_types=1);

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ' . 'http://' . $_ENV['HOST_ADRESS'] . ':' . $_ENV['HOST_PORT']);
  die();
};

require('./Person.class.php');

Person::migrate();

header('Location: ' . 'http://' . $_ENV['HOST_ADRESS'] . ':' . $_ENV['HOST_PORT']);
die();