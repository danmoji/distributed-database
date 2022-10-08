<?php 

declare(strict_types=1);

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ' . 'http://' . $_ENV['HOST_ADRESS'] . ':' . $_ENV['HOST_PORT']);
  die();
};

require_once('Person.class.php');
$name = $_POST['name'];
$creatorNodesName = $_ENV["HOST_NAME"];
$person = new Person();

print_r($person->create_person($name, $creatorNodesName));
// die();