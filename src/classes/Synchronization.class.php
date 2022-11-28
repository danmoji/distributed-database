<?php declare(strict_types=1);
require_once('Api.class.php');
require_once('Queue.class.php');
class Synchronization {
  public function __construct()
  {
    $this->filteredNodeAdresses = (new Nodes())->filteredNodeAdresses;
    $this->host = $_ENV['HOST_ADRESS'] | '';
  }

  public function syncAll() {
    $nodeAdresses = $this->filteredNodeAdresses;
    $queue = new Queue();
    foreach($nodeAdresses as $nodeAdress) {
      $data = $queue->selectAllUnsyncedQueriesOfOneDistatnNode($nodeAdress);
      echo '<pre>';
      print_r($data);
      echo '</pre>';
      die();
      $url = "http://" . $nodeAdress . 'syncdata.php';
      foreach($data as $payload) {
        $response = $this->sync($url, $payload);
        if($response) {
        }
        
      }
      //if 200 then delete query if false then keep it
    }
  }

  private function sync(string $url, array $payload): void {
    try {
      Api::post($url, $payload);
    } catch(Exception $error) {
      echo '<pre>';
      print_r($error);
      echo '</pre>';
      die();
    }
  }
}