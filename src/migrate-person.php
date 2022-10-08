<?php declare(strict_types=1);

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo 'access denied!';
  die();
};

require('./Person.class.php');
Person::migrate();
echo 'success';