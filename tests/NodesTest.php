<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class NodesTest extends TestCase {
  private array $nodes;
  private array $filteredNodes;
  private string $hostNode;
  private string $nodesListAbsolutePath;

  public  function __construct()
  {
    $this->nodesListAbsolutePath = '/var/www/html/src/nodes-list.JSON';
    $this->loadedNodesJSON = file_get_contents($this->nodesListAbsolutePath);
  } 
  
  public function testFileNodesList():void {
    $this->assertFileExists($this->nodesListAbsolutePath);
    $this->assertFileIsReadable($this->nodesListAbsolutePath);
  }

  public function testNodes(): void {
    $this->
  }

  public function testFilteredNodes():void {
    
    $this->
  }
}