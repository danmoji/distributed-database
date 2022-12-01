<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class ApiTest extends TestCase {

  /**
   * 
   * @test
   */
  public function testPost(): void {
    $result = Api::post('',[]);
    $this->assertTrue($result);
    
  }

}