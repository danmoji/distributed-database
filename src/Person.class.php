<?php declare(strict_types=1);

//TODO connect to the database

require_once('./Dbh.class.php');

class Person extends Dbh {
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

   public function dbConnect() {
      try {
         $dbh = new Dbh();
         return $dbh->connect();
      } catch(error $e) {
         return $e;
      }
   }
}