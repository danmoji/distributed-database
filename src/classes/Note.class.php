<?php

declare(strict_types=1);

require_once('Dbh.class.php');
require_once('HandleException.class.php');

class Note extends Dbh
{
  private PDO $dbh;
  private HandleException $handleException;
  private array $noteData; //TODO this does not exist


  public function __construct()
  {
    $this->dbh = (new Dbh())->connect();
    $this->handleException = new HandleException();
  }

  public function fetchAllNotesFromDb(): array
  {
    $sql = "SELECT * FROM note";
    try {
      $stmt = $this->dbh->query($sql);
      $result = $stmt->fetchAll();
    } catch (Exception $e) {
      $this->handleException->formatAndPrint($e);
    }
    return $result;
  }

  public function saveNote(): mixed
  {
    $noteData = $this->getNoteData;
    $sql = "INSERT INTO note (note_title, note_description, note_hash_key, creator_node_name) VALUES (?, ?, ?, ?)";
    try {
      $stmt = $this->dbh->prepare($sql);
      $result = $stmt->execute($noteData);
    } catch (Exception $e) {
      $this->handleException->formatAndPrint($e);
    }
    return $result;
  }

  public function deleteNote(): mixed
  {
    $sql = "DELETE FROM note WHERE note_hash_key=?";
    try {
      $stmt = $this->dbh->prepare($sql);
      $result = $stmt->execute([$this->noteHashKey]);
    } catch (Exception $e) {
      $this->handleException->formatAndPrint($e);
    }
    return $result;
  }

  public function updateNote(): mixed
  {
    $sql = "UPDATE note SET note_title=?, note_description=? WHERE note_hash_key=?";
    try {
      $stmt = $this->dbh->prepare($sql);
      $result = $stmt->execute([$this->noteTitle, $this->noteDescription, $this->noteHashKey]);
    } catch (Exception $e) {
      $this->handleException->formatAndPrint($e);
    }
    return $result;
  }


  public function migrate()
  {
    $sql =
      '
      DROP TABLE IF EXISTS note;
      CREATE TABLE note(
         note_id INT AUTO_INCREMENT,
         note_title LONGTEXT NOT NULL, 
         note_description LONGTEXT NOT NULL, 
         creator_node_name VARCHAR(100) NOT NULL,
         note_hash_key VARCHAR(100) NOT NULL,
         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
         updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
         PRIMARY KEY(note_id)
       );';
    try {
      $this->dbh->exec($sql);
    } catch (Exception $e) {
      $this->handleException->formatAndPrint($e);
    }
  }
}
