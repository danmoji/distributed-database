<?php

declare(strict_types=1);

require_once('Dbh.class.php');

class Note extends Dbh
{
  public function __construct(array $post = null)
  {
    if ($post !== null) {
      $this->noteTitle = $post['note_title'];
      $this->noteDescription = $post['note_description'];
      $this->noteHashKey = isset($post['note_hash_key']) ? $post['note_hash_key'] : $this->createRandomHashKey();
      $this->creatorNodeName = $_ENV['HOST_NAME'];
    }
    $this->dbh = (new Dbh())->connect();
  }

  public function fetchAllNotesFromDb()
  {
    $dbh = (new Dbh())->connect();
    $sql = "SELECT * FROM note";
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll();
    return $result;
  }

  public function saveNote()
  {
    $noteData = $this->getNoteData();
    $sql = "INSERT INTO note (note_title, note_description, note_hash_key, creator_node_name) VALUES (?, ?, ?, ?)";
    try {
      $stmt = $this->dbh->prepare($sql);
      $noteDataValues = array_values($noteData);
      $result = $stmt->execute($noteDataValues);
    } catch (Exception $e) {
      $this->printError($e);
    }
    return $result;
  }

  public function deleteNote():mixed {
    $sql = "DELETE FROM note WHERE note_hash_key=?";
    $noteHashKey = $this->noteHashKey;
    try {
      $stmt = $this->dbh->prepare($sql);
      $result = $stmt->execute([$noteHashKey]);
    } catch (Exception $e) {
      $this->printError($e);
    }
    return $result;
  }

  public function updateNote(): mixed {
    $sql = "UPDATE note SET note_title=?, note_description=? WHERE creator_node_key=?";
    $noteTitle = $this->noteTitle;
    $noteDescription = $this->noteDescription;
    try {
      $stmt = $this->dbh->prepare($sql);
      $result = $stmt->execute([$noteTitle, $noteDescription]);
    } catch (Exception $e) {
      $this->printError($e);
    }
    return $result;
  }

  private function createRandomHashKey(): string
  {
    return substr(md5(openssl_random_pseudo_bytes(20)), -32);
  }

  private function printError(Exception $e) {
    echo '<pre>';
    print_r($e);
    echo '</pre>';
  }

  public function getNoteData()
  {
    return [
      'note_title' => $this->noteTitle,
      'note_description' => $this->noteDescription,
      'note_hash_key' => $this->noteHashKey,
      'creator_node_name' => $this->creatorNodeName,
    ];
  }

  public static function migrate()
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
    $dbh = (new Dbh())->connect();
    $dbh->exec($sql);
  }
}
