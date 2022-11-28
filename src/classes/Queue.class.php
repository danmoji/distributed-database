<?php declare(strict_types=1);

require_once("Dbh.class.php");
require_once("Nodes.class.php");
require_once("Api.class.php");

class Queue extends Dbh {
  public function __construct() {
    $this->dbh = (new Dbh())->connect();
  }

  public function saveUnsyncedNotes(array $noteData) : void {
    $nodeAdresses = $this->filteredNodeAdresses;
    foreach($nodeAdresses as $nodeAdress) {
      $noteData = array_values($noteData);
      $noteData[4] = $nodeAdress;
      $this->saveOneUnsyncedNote($noteData);
    }
  }

  private function saveOneUnsyncedNote(array $noteData): void {
    $sql = "INSERT INTO queue (note_title, note_description, note_hash_key, creator_node_name, distant_node_adress) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->dbh->prepare($sql);
    try {
      $stmt->execute($noteData);
    } catch(Exception $error) {
      echo '<pre>';
      print_r($error);
      echo '</pre>';
      die();
    }
  }

  public function selectAllUnsyncedQueriesOfOneDistatnNode(string $nodeAdress):array {
      $sql = "SELECT * FROM queue WHERE distant_node_adress=? ORDER BY queue_id DESC";
      $stmt = $this->dbh->prepare($sql);
      $stmt->execute([$nodeAdress]);
      $data = $stmt->fetchAll();
      return $data;
  }

  
}