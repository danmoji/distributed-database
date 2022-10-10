<?php declare(strict_types=1);

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo "connection refused!";
  die();
};

require('./Person.class.php');

try {
  //TODO ak sa vráti true tak vypíš miration successful
  Person::migrate();
  //TODO ak sa vráti niečo iné tak napíš not successful
  echo "migration successful!";
} catch(Exception $e) {
  print_r($e);
} finally {
  die();
}
