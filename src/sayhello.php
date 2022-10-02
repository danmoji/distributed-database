<?php declare(strict_types=1);
if($_SERVER['REQUEST_METHOD'] === 'GET') {
  echo "Hello from " . $_ENV["HOST_NAME"];
  die();
} else {
  die();
}