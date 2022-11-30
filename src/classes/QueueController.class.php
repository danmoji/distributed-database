<?php

require_once('Queue.class.php');
require_once('Nodes.class.php');

class QueueController extends Queue {
  
  private Nodes $nodes;
  private array $filteredNodeAdresses;

  public function __construct(array $queueData) {
    $this->data = $queueData;
    $this->nodes = new Nodes();
    $this->filteredNodeAdresses = $this->nodes->filteredNodes;
  }

  public function saveUnsyncedNote(array $noteData) : void {
    $nodeAdresses = $this->filteredNodeAdresses;
    foreach($nodeAdresses as $nodeAdress) {
      $dataForNode = $noteData;
      $dataForNode['distant_node_adress'] = $nodeAdress;
      $dataForNode = array_values($dataForNode);
      $this->saveUnsyncedNoteForOneDistantNode($dataForNode);
    }
  }
}