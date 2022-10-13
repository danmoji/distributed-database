<?php

declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo "failed";
  die();
};

require_once "./pdo.php";

$sql =
  '
      DROP TABLE IF EXISTS person;
      CREATE TABLE person( 
         person_id INT AUTO_INCREMENT,
         personal_information LONGTEXT NOT NULL, 
         creator_nodes_name VARCHAR(100) NOT NULL,
         PRIMARY KEY(person_id)
       );';
pdo()->exec($sql);

header("Location: http://" . $_ENV["HOST_ADRESS"] . ':' . $_ENV["HOST_PORT"]);
die();