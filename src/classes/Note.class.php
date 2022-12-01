<?php declare(strict_types=1);

require_once('Dbh.class.php');
require_once('HandleException.class.php');
class Note extends Dbh
{
  private PDO $dbh;
  private HandleException $handleException;

  private string $noteMigration =
  '
  DROP TABLE IF EXISTS note;
  CREATE TABLE note(
     note_id INT AUTO_INCREMENT,
     note_title LONGTEXT NOT NULL, 
     note_description LONGTEXT NOT NULL, 
     note_hash_key VARCHAR(100) NOT NULL,
     creator_node_name VARCHAR(100) NOT NULL,
     is_deleted VARCHAR(100) NOT NULL,
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
     updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
     PRIMARY KEY(note_id)
   );';

  protected function __construct()
  {
    $this->dbh = (new Dbh())->connect();
    $this->handleException = new HandleException();
  }

  protected function save(array $dataToSave): bool
  {
    $sql = "INSERT INTO note (note_title, note_description, note_hash_key, creator_node_name, is_deleted) VALUES (?, ?, ?, ?, ?)";
    try {
      $stmt = $this->dbh->prepare($sql);
      $result = $stmt->execute($dataToSave);
    } catch (Exception $e) {
      $this->handleException->formatAndPrint($e);
    }
    return $result;
  }

  protected function update(array $dataToUpdate): bool
  {
    $sql = "UPDATE note SET note_title=?, note_description=? WHERE note_hash_key=?";
    try {
      $stmt = $this->dbh->prepare($sql);
      $result = $stmt->execute($dataToUpdate);
    } catch (Exception $e) {
      $this->handleException->formatAndPrint($e);
    }
    return $result;
  }

  protected function delete(array $dataToDelete): bool
  {
    $sql = "UPDATE note SET is_deleted=? WHERE note_hash_key=?";
    try {
      $stmt = $this->dbh->prepare($sql);
      $result = $stmt->execute($dataToDelete);
    } catch (Exception $e) {
      $this->handleException->formatAndPrint($e);
    }
    return $result;
  }

  protected function selectOne(array $noteHashKey): array
  {
    $sql = "SELECT * FROM note WHERE note_hash_key=? LIMIT 1";
    try {
      $stmt = $this->dbh->prepare($sql);
      $stmt->execute($noteHashKey);
      $result = $stmt->fetch();
    } catch (Exception $e) {
      $this->handleException->formatAndPrint($e);
    }
    return $result;
  }

  protected function selectAll(): array
  {
    $sql = "SELECT * FROM note WHERE is_deleted='false'";
    try {
      $stmt = $this->dbh->query($sql);
      $result = $stmt->fetchAll();
    } catch (Exception $e) {
      $this->handleException->formatAndPrint($e);
    }
    return $result;
  }

  protected function migrate(): void
  {
    $sql = $this->noteMigration;
    try {
      $this->dbh->exec($sql);
    } catch (Exception $e) {
      $this->handleException->formatAndPrint($e);
    }
  }
}
