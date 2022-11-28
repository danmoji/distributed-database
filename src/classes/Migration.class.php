<?php

require_once "Dbh.class.php";

class Migration extends Model {

  public function __construct()
  {
    //you input column names and their data types
    //from that you calculate and input column strings to Model constructor
    // private string $allColumnNames;
    // private string $preparedStmtBuffer;
    // private string $tableName;
    // private string $mainIdColumnName;
    // private string $updatableColumnsString;
  }

  public function migrate() {
    $this->migrateNote();
    $this->migrateQueue();
  }

  private function migrateQueue() {
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
           created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
           updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
           PRIMARY KEY(queue_id)
         );';
      $this->dbh->exec($sql);
  }

  private function migrateNote()
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
    $this->dbh->exec($sql);
  }
}