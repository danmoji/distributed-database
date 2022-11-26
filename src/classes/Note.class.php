<?php

declare(strict_types=1);

require_once('Dbh.class.php');

class Note extends Dbh
{
  public function __construct(array $noteData)
  {
    $this->dbh = (new Dbh())->connect();
    $this->noteData = $noteData;
  }

  public function selectAll()
  {
    $sql = "SELECT * FROM note";
    $stmt = $this->dbh->query($sql);
    $result = $stmt->fetchAll();
    return $result;
  }

  public function delete(int $creatorNodeKey)
  {
    $sql = "DELETE FROM note WHERE creator_node_key=?";
    $stmt = $this->dbh->prepare($sql);
    $stmt->execute([$creatorNodeKey]);
  }

  public function saveNote()
  {
    $sql = "INSERT INTO note (note_title, note_description, note_key_hash, creator_node_key) VALUES (?, ?, ?, ?)";
    $stmt = $this->dbh->prepare($sql);
    $noteData = $this->noteData;
    print_r($noteData);
    print_r(...$noteData);
    die();
    $stmt->execute([...($this->noteData)]);
  }

  public function update(string $noteTitle, string $noteDescription, string $creatorNodeKey)
  {
    $sql = "UPDATE note SET note=?, description=? WHERE creator_node_key=?";
    $stmt = $this->dbh->prepare($sql);
    $stmt->execute([$noteTitle, $noteDescription, $creatorNodeKey]);
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
         note_key_hash VARCHAR(100) NOT NULL,
         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
         updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
         PRIMARY KEY(note_id)
       );';
    $this->dbh->exec($sql);
  }
}
