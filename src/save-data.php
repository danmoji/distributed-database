<?php

require_once './pdo.php';
require_once './Api.class.php';

$nodesList = file_get_contents('./nodes-list.JSON');

foreach(json_decode($nodesList, $asspciative=1)['nodes'] as $node){
  if($_ENV['HOST_NAME'] !== $node ) {
    $url = 'http://sql-a_web_1/hello.php';
    var_dump(Api::post($url, ''));

  }
  
}

die();
if(!isset($_POST['id'])) {
  $sql = 'INSERT INTO person (personal_information, creator_nodes_name) VALUES (?, ?)';
  pdo()->prepare($sql)->execute([$_POST['name'], $_ENV['HOST_NAME']]);

  //následne odošle požiadavku ostatným uzlom

  // Api::post('localhost', $_POST['name']);
}

// if(isset($_POST['id']) && $_POST['id'] === 2) {
//   $sql = 'INSERT INTO person (personal_information) VALUES (?)';
//   pdo()->prepare($sql)->execute([$_POST['name']]);
// }

header("Location: http://" . $_ENV["HOST_ADRESS"] . ':' . $_ENV["HOST_PORT"]);
die();