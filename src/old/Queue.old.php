<?php declare(strict_types=1);

require_once("Dbh.class.php");

class Queue extends Dbh {
  public function __construct() {
    $dbh = new Dbh();
    $this->dbh = $dbh->connect();
  }

  public function selectAllUnsyncedQueries(string $nodeAdress) {
    $sql = "SELECT * FROM queue WHERE distant_node_adress=? ORDER BY queue_id DESC";
    $stmt = $this->dbh->prepare($sql);
    $stmt->execute([$nodeAdress]);
    $data = $stmt->fetchAll();
    return $data;
  }

  public function deleteSyncedQuery(string $distantNodesAdress, string $creatorsNodeKey) {
    $sql = "DELETE FROM queue WHERE distant_node_adress=? AND creator_node_key=?";
    $stmt = $this->dbh->prepare($sql);
    $stmt->execute([$distantNodesAdress, $creatorsNodeKey]);
  }

  public function createUnsyncedQuery(string $noteTitle, string $noteDescription, string $creatorsNodeName, string $creatorsNodeKey, string $distantNodesAdress) {
    $sql = "INSERT INTO queue (note_title, note_description, creator_node_name, creator_node_key, distant_node_adress) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->dbh->prepare($sql);
    $stmt->execute([$noteTitle, $noteDescription, $creatorsNodeName, $creatorsNodeKey, $distantNodesAdress]);
  }

  public function updateUnsyncedQuery(string $noteTitle, string $noteDescription, string $creatorsNodeName, string $creatorsNodeKey, string $distantNodesAdress) {
    $sql = "UPDATE queue SET note_title=?, note_description=?, creator_node_name=? WHERE creator_node_key=? AND disant_node_adress=?";
    $stmt = $this->dbh->prepare($sql);
    $stmt->execute([$noteTitle, $noteDescription, $creatorsNodeName, $creatorsNodeKey, $distantNodesAdress]);
  }

  public function migrate() {
    $sql =
  '
      DROP TABLE IF EXISTS queue;
      CREATE TABLE queue( 
         queue_id INT AUTO_INCREMENT,
         note_title LONGTEXT NOT NULL,
         note_description LONGTEXT NOT NULL,
         creator_node_name VARCHAR(100) NOT NULL,
         creator_node_key VARCHAR(100) NOT NULL,
         distant_node_adress VARCHAR(100) NOT NULL,
         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
         updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
         PRIMARY KEY(queue_id)
       );';
    $this->dbh->exec($sql);
  }
}