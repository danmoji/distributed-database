<?php

declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo "failed";
  die();
};
//TODO created at and updated at columns
require_once "./pdo.php";
$sql =
  '
      DROP TABLE IF EXISTS queue;
      CREATE TABLE queue( 
         queue_id INT AUTO_INCREMENT,
         personal_information VARCHAR(100) NOT NULL,
         creator_node_name VARCHAR(100) NOT NULL,
         creator_node_key VARCHAR(100) NOT NULL,
         node_adress VARCHAR(100) NOT NULL,
         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
         updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
         PRIMARY KEY(queue_id)
       );';
pdo()->exec($sql);

header("Location: http://" . $_ENV["HOST_ADRESS"] . ':' . $_ENV["HOST_PORT"]);
die();