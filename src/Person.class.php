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

   //just for db connection testing purpose
   public function dbConnect() {
      try {
         $dbh = new Dbh();
         return $dbh->connect();
      } catch(error $e) {
         return $e;
      }
   }
}