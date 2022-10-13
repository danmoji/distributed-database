<?php

function pdo()
{
  $host = $_ENV['HOST_DB_ADRESS'];
  $port = $_ENV['HOST_DB_PORT'];
  $user = $_ENV['HOST_DB_USER'];
  $password = $_ENV['HOST_DB_PASSWORD'];
  $dbName = $_ENV['HOST_DB_NAME'];

  $dsn = 'mysql:host=' . $host . ';port=' . $port . ';dbname=' . $dbName;
  $pdo = new PDO($dsn, $user, $password);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  return $pdo;
}
