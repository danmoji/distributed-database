<?php 

declare(strict_types=1);

class Api {
  public static function post(string $url, array $payload): string|Exception {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch,CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      $response = curl_exec($ch);
      $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);
      if (200==$retcode) {
          return $response;
      } else {
        throw new Exception('Could not connect to host: ' . $url);
      }
  }
}