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

   //test db connection
   public function dbConnect()
   {
      try {
         $dbh = new Dbh();
         return "connection successful!";
      } catch (error $e) {
         return $e;
      }
   }

   public static function migrate()
   {
      try {
         // SQL statement for creating new tables
         $statements = [
            'CREATE TABLE person( 
        person_id   INT AUTO_INCREMENT,
        person_data  LONGTEXT NOT NULL, 
        creator_nodes_name   VARCHAR(100) NOT NULL,
        tracking_id   VARCHAR(100) NOT NULL,
        PRIMARY KEY(person_id)
    );'
         ];

         //TODO connect to the database
         $dbh = require 'Dbh.php';

         // execute SQL statements
         foreach ($statements as $statement) {
            $pdo->exec($statement);
         }
      } catch (error $e) {
         return $e;
      }
   }
}
