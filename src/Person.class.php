<?php declare(strict_types=1);

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

   //test db connection
   public function dbConnect() {
      try {
         $dbh = new Dbh();
         return "connection successful!";
      } catch(error $e) {
         return $e;
      }
   }

   public static function migrate() {
      //TODO create migration schema for Person table
      try {
         return true;
      } catch(error $e) {
         return $e;
      }
   }
}