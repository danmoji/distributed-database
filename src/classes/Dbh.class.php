<?php declare(strict_types=1);

class Dbh {
  protected function __construct()
  {
    $this->host = $_ENV['HOST_DB_ADRESS'];
    $this->port = $_ENV['HOST_DB_PORT'];
    $this->user = $_ENV['HOST_DB_USER'];
    $this->password = $_ENV['HOST_DB_PASSWORD'];
    $this->dbName = $_ENV['HOST_DB_NAME'];
    $this->dsn = 'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbName;
  }

  protected function  connect() {
    $dsn = $this->dsn;
    $user = $this->user;
    $password = $this->password;
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
  }
}
