<?php declare(strict_types=1);

class Dbh {
  //TODO add variables from connections.env
  private string $host = 'localhost';
  private string $user = 'root';
  private string $password = 'rootpass';
  private string $dbName = 'db-a';

  protected function connect() {
    $dsn = 'mysql:host=' . $this->host .';dbname=' . $this->dbName;
    $pdo = new PDO($dsn, $this->user, $this->pwd);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
  }
}