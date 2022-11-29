<?php

class Nodes {
  private array $nodes;
  public string $hostNode;
  public array $filteredNodes;

  public function __construct()
  {
    $this->loadedNodesJSON = file_get_contents('../nodes-list.JSON');
    $this->nodes = json_decode($this->loadedNodesJSON, true)['nodes'];
    $this->hostNode = $_ENV['HOST_NAME'];
    $this->filteredNodes = $this->filterAdresses();
  }

  private function filterAdresses(): array {
    $nodes = $this->nodes;
    $filteredNodes = array_filter($nodes, function ($node) {
      return $node !== $this->hostNode;
    });
    return $filteredNodes;
  }

}