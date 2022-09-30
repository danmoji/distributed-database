<?php declare(strict_types=1);

class Person {
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
}