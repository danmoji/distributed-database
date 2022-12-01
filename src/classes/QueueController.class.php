<?php declare(strict_types=1);

require_once("Nodes.class.php");
require_once("Queue.class.php");
class QueueController extends Queue {
  private Queue $queue;
  private Nodes $nodes;

  public function __construct()
  {
    $this->queue = new Queue();
    $this->nodes = new Nodes();
  }

  public function saveUnsyncedNote(array $noteData): void {
    foreach($this->nodes->filteredNodes as $nodeAdress) {
      $dataForNode = $this->prepareNoteData($noteData, $nodeAdress);
      $this->queue->saveNodesNote($dataForNode);
    }
  }

  public function deleteAllSyncedNotes(array $syncedNotes): void {
    foreach($syncedNotes as $syncedNote) {
      $this->queue->delete($syncedNote);
    }
  }

  public function fetchAllNotes(): array {
    return $this->queue->fetchAll();
  }

  public function migrateQueue(): void {
    $this->queue->migrate();
  }

  public function prepareNoteData(array $nodeData, string $nodeAdress): array {
      $data = $nodeData;
      $data['distant_node_adress'] = $nodeAdress;
      $data = array_values($data);
      return $data;
  }

}