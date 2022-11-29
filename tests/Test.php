<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertEmpty;

final class Test extends TestCase
{
  


    public function testOne(): void {
      $response = Api::post('',[]);
      $this->assertFalse(
        $response 
      );
      
    }

    public function testTwo(): void
    {
      $this->assertTrue(true);
    }
}