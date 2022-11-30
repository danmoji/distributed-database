<?php declare(strict_types=1);

class HandleException {
  public function formatAndPrint(Exception $e) :void {
      echo '<pre>';
      print_r($e->getMessage() . ' in file: ' . $e->getFile() . ' on line: ' . $e->getLine());
      echo '</pre>';
      die();
  }
}