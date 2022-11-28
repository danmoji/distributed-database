<?php

class Nodes {
  private array $nodes;
  public string $hostNode;
  public array $filteredNodes;

  public function __construct()
  {
    $this->nodes = json_decode(file_get_contents('../nodes-list.JSON'), true)['nodes'];
    $this->hostNode = $_ENV['HOST_NAME'];
    $this->filteredNodeAdresses = $this->filterAdresses();
  }

  private function filterAdresses(): array {
    $nodes = $this->nodes;
    $filteredNodes = array_filter($nodes, function ($node) {
      return $node !== $this->hostNode;
    });
    return $filteredNodes;
  }

}