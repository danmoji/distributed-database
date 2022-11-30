<?php

declare(strict_types=1);

require_once('Dbh.class.php');
require_once('HandleException.class.php');

class Note extends Dbh
{
  private PDO $dbh;
  private HandleException $handleException;
  private string $noteTitle;
  private string $noteDescription;
  private string $noteHashKey;
  private string $creatorNodeName;
  private string $method;

  public function __construct(array $post = null)
  {
    $this->construcNoteFromPostParams($post);
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
    $noteData = $this->getNoteData();
    unset($noteData['method']);
    $noteDataValues = array_values($noteData);
    $sql = "INSERT INTO note (note_title, note_description, note_hash_key, creator_node_name) VALUES (?, ?, ?, ?)";
    try {
      $stmt = $this->dbh->prepare($sql);
      $result = $stmt->execute($noteDataValues);
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

  private function construcNoteFromPostParams(array|null $post):void
  {
    if ($post !== null) {
      $this->noteTitle = $post['note_title'];
      $this->noteDescription = $post['note_description'];
      $this->noteHashKey = isset($post['note_hash_key']) ? $post['note_hash_key'] : $this->createRandomHashKey();
      $this->creatorNodeName = $_ENV['HOST_NAME'];
      $this->method = $post['method'];
    }
  }

  public function getNoteData(): array
  {
    return [
      'note_title' => $this->noteTitle,
      'note_description' => $this->noteDescription,
      'note_hash_key' => $this->noteHashKey,
      'creator_node_name' => $this->creatorNodeName,
      'method' => $this->method
    ];
  }

  private function createRandomHashKey(): string
  {
    return substr(md5(openssl_random_pseudo_bytes(20)), -32);
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
