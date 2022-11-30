<?php declare(strict_types=1);

use PhpParser\Node\Expr\AssignOp\Mod;

require_once 'Model.class.php';



class NoteModel extends Model {
  public function __construct()
  {
    $something = [
      'column_names' => 'wfdsfdsf'
      'table_name' => 
    ];
    $model = new Model($something);
  }




  //TODO desctructure and move this to model class
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