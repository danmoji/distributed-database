<?php declare(strict_types=1);

class Api {
  public function get(string $url) {
    try {
      $curl = curl_init();
    
      if ($curl === false) {
          throw new Exception('failed to initialize connection');
      }
    
      curl_setopt($curl, CURLOPT_URL, $url);
      // That needs to be set; content will spill to STDOUT otherwise
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
      
      $response = curl_exec($curl);
    
      if ($response === false) {
          throw new Exception(curl_error($curl), curl_errno($curl));
      }
    
      // Check HTTP return code; might be something else than 200
      //TODO integrate this
      $httpReturnCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
      //Process response
      return $response;
    
    } catch(Exception $e) {
    
      return trigger_error(sprintf(
          'Curl failed with error #%d: %s',
          $e->getCode(), $e->getMessage()),
          E_USER_ERROR);
    
    } finally {
      // Close curl handle unless it failed to initialize
      if (is_resource($curl)) {
          curl_close($curl);
      }
    }
  }
}

