<?php declare(strict_types=1);

class Dbh {

  
  //TODO add variables from connections.env

  private ?string $host;
  private ?string $port;
  private ?string $user;
  private ?string $password;
  private ?string $dbName;

  public function __construct()
  {
    $this->host = $_ENV['HOST_DB_ADRESS'];
    $this->port = $_ENV['HOST_DB_PORT'];
    $this->user = $_ENV['HOST_DB_USER'];
    $this->password = $_ENV['HOST_DB_PASSWORD'];
    $this->dbName = $_ENV['HOST_DB_NAME'];
  }

  protected function connect() {
    $dsn = 'mysql:host=' . $this->host .';port=' . $this->port . ';dbname=' . $this->dbName;
    var_dump($dsn);
    $pdo = new PDO($dsn, $this->user, $this->password);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
  }
}