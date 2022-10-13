<?php declare(strict_types=1);

class Api {
  public static function post(string $url, string $post) {
    try {
      $curl = curl_init();
    
      if ($curl === false) {
          throw new Exception('failed to initialize connection');
      }
    
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl,CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
      
      $response = curl_exec($curl);
    
      if ($response === false) {
          throw new Exception(curl_error($curl), curl_errno($curl));
      }
    
      $httpReturnCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
      return $response;
    
    } catch(Exception $e) {
    
      return trigger_error(sprintf(
          'Curl failed with error #%d: %s',
          $e->getCode(), $e->getMessage()),
          E_USER_ERROR);
    
    } finally {
      if (is_resource($curl)) {
          curl_close($curl);
      }
    }
  }
  public static function get(string $url) {
    try {
      $curl = curl_init();
    
      if ($curl === false) {
          throw new Exception('failed to initialize connection');
      }
    
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      // curl_setopt($curl,CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
      // curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
      
      $response = curl_exec($curl);
    
      if ($response === false) {
          throw new Exception(curl_error($curl), curl_errno($curl));
      }
    
      $httpReturnCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
      return $response;
    
    } catch(Exception $e) {
    
      return trigger_error(sprintf(
          'Curl failed with error #%d: %s',
          $e->getCode(), $e->getMessage()),
          E_USER_ERROR);
    
    } finally {
      if (is_resource($curl)) {
          curl_close($curl);
      }
    }
  }
}