<?php

declare(strict_types=1);

require_once("Dbh.class.php");
require_once("Nodes.class.php");
require_once("Api.class.php");
require_once("HandleException.class.php");

class Queue extends Dbh
{
  private PDO $dbh;
  private HandleException $handleException;

  private string $queueMigration =
  '
  DROP TABLE IF EXISTS queue;
  CREATE TABLE queue( 
     queue_id INT AUTO_INCREMENT,
     note_title LONGTEXT NOT NULL,
     note_description LONGTEXT NOT NULL,
     note_hash_key VARCHAR(100) NOT NULL,
     creator_node_name VARCHAR(100) NOT NULL,
     is_deleted VARCHAR(100) NOT NULL,
     method VARCHAR(100) NOT NULL,
     distant_node_adress VARCHAR(100) NOT NULL,
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
     updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
     PRIMARY KEY(queue_id)
   );';

  protected function __construct()
  {
    $this->dbh = (new Dbh())->connect();
    $this->handleException = new HandleException();
  }

  public function saveNodesNote(array $noteData): bool
  {
    $sql = "INSERT INTO queue (note_title, note_description, note_hash_key, creator_node_name, is_deleted, method, distant_node_adress) VALUES (?, ?, ?, ?, ?, ?, ?)";
    try {
      $stmt = $this->dbh->prepare($sql);
      $result = $stmt->execute($noteData);
    } catch (Exception $e) {
      $this->handleException->formatAndPrint($e);
    }
    return $result;
  }

  protected function fetchAll(): array|false {
    $sql = "SELECT * FROM queue ORDER BY queue_id DESC";
    try {
      $stmt = $this->dbh->query($sql);
      $result = $stmt->fetchAll();
    } catch (Exception $e) {
      $this->handleException->formatAndPrint($e);
    }
    return $result;
  }

  protected function fetchNodesNotes(array $nodeAdress): array|false
  {
    $sql = "SELECT * FROM queue WHERE distant_node_adress=? ORDER BY queue_id DESC";
    try {
      $stmt = $this->dbh->prepare($sql);
      $stmt->execute($nodeAdress);
      $data = $stmt->fetchAll();
    } catch (Exception $e) {
      $this->handleException->formatAndPrint($e);
    }
    return $data;
  }

  protected function delete(array $dataToDelete): bool
  {
    $sql = "DELETE FROM queue WHERE distant_node_adress=? AND note_hash_key=?";
    try {
      $stmt = $this->dbh->prepare($sql);
      $result = $stmt->execute($dataToDelete);
    } catch (Exception $e) {
      $this->handleException->formatAndPrint($e);
    }
    return $result;
  }

  public function migrate()
  {
    $sql = $this->queueMigration;
    try {
      $result = $this->dbh->exec($sql);
    } catch (Exception $e) {
      $this->handleException->formatAndPrint($e);
    }
    return $result;
  }
}
