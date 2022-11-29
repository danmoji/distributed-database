<?php declare(strict_types=1);

require_once("Dbh.class.php");
require_once("Nodes.class.php");
require_once("Api.class.php");

class Queue extends Dbh {
  public function __construct() {
    $this->dbh = (new Dbh())->connect();
    $nodes = new Nodes();
    $this->filteredNodeAdresses = $nodes->filteredNodes;
  }

  public function saveUnsyncedNote(array $noteData) : void {
    $nodeAdresses = $this->filteredNodeAdresses;
    foreach($nodeAdresses as $nodeAdress) {
      $noteData['distant_node_adress'] = $nodeAdress;
      $noteData = array_values($noteData);
      $this->saveUnsyncedNoteForOneDistantNode($noteData);
    }
  }

  public function saveUnsyncedNoteForOneDistantNode(array $noteData): void {
    $sql = "INSERT INTO queue (note_title, note_description, note_hash_key, creator_node_name, distant_node_adress) VALUES (?, ?, ?, ?, ?)";
    try {
      $stmt = $this->dbh->prepare($sql);
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
      try {
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([$nodeAdress]);
        $data = $stmt->fetchAll();
      } catch (Exception $e) {
        echo '<pre>';
        print_r($e);
        echo '</pre>';
        die();
      }
      return $data;
  }

  public function deleteSyncedQuery(string $distantNodesAdress, string $creatorsNodeKey) {
    $sql = "DELETE FROM queue WHERE distant_node_adress=? AND note_hash_key=?";
    $stmt = $this->dbh->prepare($sql);
    $stmt->execute([$distantNodesAdress, $creatorsNodeKey]);
  }

  
  public static function migrate() {
    $sql =
  '
      DROP TABLE IF EXISTS queue;
      CREATE TABLE queue( 
         queue_id INT AUTO_INCREMENT,
         note_title LONGTEXT NOT NULL,
         note_description LONGTEXT NOT NULL,
         note_hash_key VARCHAR(100) NOT NULL,
         creator_node_name VARCHAR(100) NOT NULL,
         distant_node_adress VARCHAR(100) NOT NULL,
         method VARCHAR(100) NOT NULL,
         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
         updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
         PRIMARY KEY(queue_id)
       );';
    $dbh = (new Dbh())->connect();
    $dbh->exec($sql);
}
}