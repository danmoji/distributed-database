<?php declare(strict_types=1);

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ' . 'http://' . $_ENV['HOST_ADRESS'] . ':' . $_ENV['HOST_PORT']);
  die();
};

require('./Person.class.php');

$name = $_POST['name'];

$mike = new Person($name);

echo 'Hello ' . $mike->getName() . '!';

echo '<br>TESTING DB ';

print "<pre>";
print_r($mike->dbConnect());
print "</pre>";