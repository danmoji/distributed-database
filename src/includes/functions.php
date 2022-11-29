<?php

// declare(strict_types=1);

// require_once('../classes/Api.class.php');
// require_once('../classes/Queue.class.php');



// function syncAll($filteredNodeAdresses): void
// {
//   $nodeAdresses = $filteredNodeAdresses;
//   $queue = new Queue();
//   foreach ($nodeAdresses as $nodeAdress) {
//     $data = $queue->selectAllUnsyncedQueriesOfOneDistatnNode($nodeAdress);
//     echo '<pre>';
//     print_r($data);
//     echo '</pre>';
//     die();
//     $url = "http://" . $nodeAdress . 'syncdata.php';
//     foreach ($data as $payload) {
//       $response = sync($url, $payload);
//       if ($response === '200') {
//         print_r('Response OK');
//       } else {
//         print_r('Response OK');
//       }
//     }
//     //if 200 then delete query if false then keep it
//   }
// }

// function sync(string $url, array $payload): void
// {
//   try {
//     Api::post($url, $payload);
//   } catch (Exception $error) {
//     echo '<pre>';
//     print_r($error);
//     echo '</pre>';
//     die();
//   }
// }
