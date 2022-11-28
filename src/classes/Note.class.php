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
      $this->noteHashKey = $this->createRandomHashKey();
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

  private function createRandomHashKey(): string
  {
    return substr(md5(openssl_random_pseudo_bytes(20)), -32);
  }

  private function saveNote()
  {
    $noteData = $this->getNoteData();
    $sql = "INSERT INTO note (note_title, note_description, note_hash_key, creator_node_name) VALUES (?, ?, ?, ?)";
    $stmt = $this->dbh->prepare($sql);
    $noteDataValues = array_values($noteData);
    $stmt->execute($noteDataValues);
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
}
