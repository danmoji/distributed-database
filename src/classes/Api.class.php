<?php 

declare(strict_types=1);

class Api {

  private string $connection;
  public function __construct() {
    $this->connection = 'online';
    //TODO add $_ENV connection and check its status
    //$this->connection = $_ENV['HOST_CONNECTION_STATUS']
    //if($this->connection === 'online') {set timeout to 0 and return 200}
    //if($this->conenction === 'offline') {set up some timeout and return 404}
  }
  public function post(string $url, array $payload): bool {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch,CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      curl_exec($ch);
      $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);
      if (200==$retcode) {
          return true;
      } else {
        return false;
      }
  }
}