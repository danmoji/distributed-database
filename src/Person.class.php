<?php

declare(strict_types=1);

require_once('./Dbh.class.php');

class Person extends Dbh
{
   // private string $name;

   // public function __construct(string $name)
   // {
   //    $this->name = $name;
   // }

   // public function getName()
   // {
   //    return $this->name;
   // }

   // public function setName(string $value)
   // {
   //    $this->name = $value;
   // }

   public static function migrate()
   {
      //TODO create migration schema for Person table
      $pdo = new Dbh;
      $sql =
         '
         DROP TABLE IF EXISTS person;
         CREATE TABLE person( 
            person_id INT AUTO_INCREMENT,
            personal_information LONGTEXT NOT NULL, 
            creator_nodes_name VARCHAR(100) NOT NULL,
            PRIMARY KEY(person_id)
          );';
      //TODO check return
      return $pdo->connect()->exec($sql);
   }

   public function create_person(string $personalInformation, string $creatorNodesName) {
      $pdo = new Dbh;
      $sql = "INSERT INTO person (personal_information, creator_nodes_name) VALUES (?,?)";
      $statement = $pdo->connect()->prepare($sql);
      return $statement->execute([$personalInformation, $creatorNodesName]);
   }

   public function get_all_person() {
      $db = new Dbh;
      return $db;
   }
}
