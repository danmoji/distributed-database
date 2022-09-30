<?php

//TODO establish connection to all nodes

//TODO create api instance helper function

//TODO create connection to one node

$url = 'http://localhost:8102/sayhello.php';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$data = "hello from node one";

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

try {
  $resp = curl_exec($curl);
  var_dump($resp);
} catch(error $e) {
  echo $e;
}
curl_close($curl);