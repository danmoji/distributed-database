<?php

require_once './pdo.php';
require_once './Api.class.php';

$nodes = json_decode(file_get_contents('./nodes-list.JSON'), true)['nodes'];
$personalInformation = isset($_POST['personal_information']) ? $_POST['personal_information'] : 'random name was created';
$creatorNodeName = isset($_POST['creator_node_name']) ? $_POST['creator_node_name'] : $_ENV['HOST_NAME'];
$creatorNodeKey = isset($_POST['creator_node_key']) ? $_POST['creator_node_key'] : substr(md5(openssl_random_pseudo_bytes(20)), -32);

//1 save the data
$sql = 'INSERT INTO person (personal_information, creator_node_name, creator_node_key) VALUES (?, ?, ?)';
pdo()->prepare($sql)->execute([$personalInformation, $creatorNodeName, $creatorNodeKey]);

//2 die if request comes from other node
if (isset($_POST['sync_stage'])) die('OK ' .  $_ENV["HOST_NAME"]);

//3 save query to queue
foreach ($nodes as $nodeAdress) {
  if ($_ENV['HOST_NAME'] === $nodeAdress) continue;

  $sql = "INSERT into queue (personal_information, creator_node_name, creator_node_key, node_adress) VALUES (?, ?, ?, ?)";
  $stmt = pdo()->prepare($sql);
  $stmt->execute([$personalInformation, $creatorNodeName, $creatorNodeKey, $nodeAdress]);
}

//4 try to send queued data to other nodes
foreach ($nodes as $nodeAdress) {
  if ($_ENV['HOST_NAME'] === $nodeAdress) continue;

  $sql = "SELECT * FROM queue WHERE node_adress=?";
  $stmt = pdo()->prepare($sql);
  $stmt->execute([$nodeAdress]);
  $data = $stmt->fetchAll();

  if (!$data) continue;
  foreach ($data as $row) {
    $payload = [
      'sync_stage' => '1',
      'personal_information' => $row['personal_information'],
      'creator_node_name' => $row['creator_node_name'],
      'creator_node_key' => $row['creator_node_key']
    ];

    $url = "http://" . $nodeAdress . "/save-data.php";
    $response = Api::post($url, $payload);

    //5 break out of the loop if connection was not resolved
    if (!$response) break;

    //6 delete data from queue if connection was successfull
    $sql = "DELETE FROM queue WHERE creator_node_key=? AND node_adress=?";
    $stmt = pdo()->prepare($sql);
    $stmt->execute([$row['creator_node_key'], $nodeAdress]);
  }
}

header("Location: http://" . $_ENV["HOST_ADRESS"] . ':' . $_ENV["HOST_PORT"]);
die();
