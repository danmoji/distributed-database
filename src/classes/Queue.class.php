<?php declare(strict_types=1);

require_once("Dbh.class.php");
require_once("Nodes.class.php");
require_once("Api.class.php");
require_once("HandleException.class.php");

class Queue extends Dbh {

  private Nodes $nodes;
  private PDO $dbh;
  private array $filteredNodeAdresses;
  
  public function __construct() {
    $this->dbh = (new Dbh())->connect();
    $this->nodes = new Nodes();
    $this->filteredNodeAdresses = $this->nodes->filteredNodes;
    $this->handleException = new HandleException();
  }

  public function saveUnsyncedNote(array $noteData) : void {
    $nodeAdresses = $this->filteredNodeAdresses;
    foreach($nodeAdresses as $nodeAdress) {
      $dataForNode = $noteData;
      $dataForNode['distant_node_adress'] = $nodeAdress;
      $dataForNode = array_values($dataForNode);
      $this->saveUnsyncedNoteForOneDistantNode($dataForNode);
    }
  }

  public function saveUnsyncedNoteForOneDistantNode(array $noteData): void {
    $sql = "INSERT INTO queue (note_title, note_description, note_hash_key, creator_node_name, method, distant_node_adress) VALUES (?, ?, ?, ?, ?, ?)";
    print_r($noteData);
    try {
      $stmt = $this->dbh->prepare($sql);
      $stmt->execute($noteData);
    } catch(Exception $e) {
      $this->handleException->formatAndPrint($e);
    }
  }

  public function selectAllUnsyncedQueriesOfOneDistatnNode(string $nodeAdress):array {
      $sql = "SELECT * FROM queue WHERE distant_node_adress=? ORDER BY queue_id DESC";
      try {
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([$nodeAdress]);
        $data = $stmt->fetchAll();
      } catch (Exception $e) {
        $this->handleException->formatAndPrint($e);
      }
      return $data;
  }

  public function deleteSyncedQuery(string $distantNodesAdress, string $creatorsNodeKey) {
    $sql = "DELETE FROM queue WHERE distant_node_adress=? AND note_hash_key=?";
    try {
      $stmt = $this->dbh->prepare($sql);
      $stmt->execute([$distantNodesAdress, $creatorsNodeKey]);
    } catch (Exception $e) {
      $this->handleException->formatAndPrint($e);
    }
  }

  public function migrate() {
    $sql =
  '
      DROP TABLE IF EXISTS queue;
      CREATE TABLE queue( 
         queue_id INT AUTO_INCREMENT,
         note_title LONGTEXT NOT NULL,
         note_description LONGTEXT NOT NULL,
         note_hash_key VARCHAR(100) NOT NULL,
         creator_node_name VARCHAR(100) NOT NULL,
         method VARCHAR(100) NOT NULL,
         distant_node_adress VARCHAR(100) NOT NULL,
         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
         updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
         PRIMARY KEY(queue_id)
       );';
    try {
      $this->dbh->exec($sql);
    } catch (Exception $e) {
      $this->handleException->formatAndPrint($e);
    }
}
}