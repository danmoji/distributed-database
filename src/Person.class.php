<?php

declare(strict_types=1);

require_once('./Dbh.class.php');

class Person extends Dbh
{
   private string $name;

   public function __construct(string $name)
   {
      $this->name = $name;
   }

   public function getName()
   {
      return $this->name;
   }

   public function setName(string $value)
   {
      $this->name = $value;
   }

   public static function migrate()
   {
      //TODO create migration schema for Person table
      $db = new Dbh;
      $statement =
         '
         DROP TABLE IF EXISTS person;
         CREATE TABLE person( 
            person_id INT AUTO_INCREMENT,
            personal_information LONGTEXT NOT NULL, 
            creator_nodes_name VARCHAR(100) NOT NULL,
            PRIMARY KEY(person_id)
          );';
      return $db->connect()->exec($statement);
   }
}
