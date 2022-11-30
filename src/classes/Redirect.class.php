<?php

declare(strict_types=1);

class Redirect
{

  private string $hostAdress;
  private string $hostPort;
  public function __construct()
  {
    $this->hostAdress = $_ENV['HOST_ADRESS'];
    $this->hostPort =  $_ENV["HOST_PORT"];
  }

  public function homeAndDie()
  {
    header("Location: http://" . $this->hostAdress . ':' . $this->hostPort);
    die();
  }
}
