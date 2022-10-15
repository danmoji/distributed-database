<?php

declare(strict_types=1);

require_once './pdo.php';
require_once './Api.class.php';

$nodes = json_decode(file_get_contents('./nodes-list.JSON'), true)['nodes'];
$personalInformation = isset($_POST['personal_information']) ? $_POST['personal_information'] : 'random name was created';
$creatorNodeName = isset($_POST['creator_node_name']) ? $_POST['creator_node_name'] : $_ENV['HOST_NAME'];
$creatorNodeKey = isset($_POST['creator_node_key']) ? $_POST['creator_node_key'] : substr(md5(openssl_random_pseudo_bytes(20)), -32);


//1 save data
$sql = 'INSERT INTO person (personal_information, creator_node_name, creator_node_key) VALUES (?, ?, ?)';
pdo()->prepare($sql)->execute([$personalInformation, $creatorNodeName, $creatorNodeKey]);

//2 if data did not come from other nodes save the data to queue
if (isset($_POST['sync_stage'])) die('OK ' .  $_ENV["HOST_NAME"]);


foreach ($nodes as $nodeAdress) {
  if ($_ENV['HOST_NAME'] === $nodeAdress) continue;

  $sql = "INSERT into queue (personal_information, creator_node_name, creator_node_key, node_adress) VALUES (?, ?, ?, ?)";
  $stmt = pdo()->prepare($sql);
  $stmt->execute([$personalInformation, $creatorNodeName, $creatorNodeKey, $nodeAdress]);
}

//3 take all the queue and send all data to other nodes
foreach ($nodes as $nodeAdress) {
  if ($_ENV['HOST_NAME'] === $nodeAdress) continue;

  $sql = "SELECT * FROM queue WHERE node_adress=?";
  $stmt = pdo()->prepare($sql);
  $stmt->execute([$nodeAdress]);
  $data = $stmt->fetchAll();

  if (!$data) continue;

  foreach ($data as $row) {
    //destructure row and only take what you need
    $payload = [
      'sync_stage' => '1',
      'personal_information' => $row['personal_information'],
      'creator_node_name' => $row['creator_node_name'],
      'creator_node_key' => $row['creator_node_key']
    ];

    $url = "http://" . $nodeAdress . "/save-data.php";
    $response = Api::post($url, $payload);
    if (!$response) break;

    //TODO rewrite this
    $sql = "DELETE FROM queue WHERE creator_node_key=? AND node_adress=?";
    $stmt = pdo()->prepare($sql);
    $stmt->execute([$row['creator_node_key'], $nodeAdress]);
  }
}

header("Location: http://" . $_ENV["HOST_ADRESS"] . ':' . $_ENV["HOST_PORT"]);
die();
