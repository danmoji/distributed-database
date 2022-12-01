<?php

declare(strict_types=1);

require_once('Note.class.php');

//TODO question is when is the status is_deleted going to be changed?
class NoteController extends Note
{

  private Note $note;
  private string $noteTitle;
  private string $noteDescription;
  private string $noteHashKey;
  private string $creatorNodeName;
  private string $method;
  private string $isDeleted;

  public function __construct(array $post = null)
  {
    $this->note = new Note();

    if ($post) {
      $this->noteTitle = $post['note_title'];
      $this->noteDescription = $post['note_description'];
      $this->noteHashKey = isset($post['note_hash_key']) ? $post['note_hash_key'] : $this->createRandomHashKey();
      $this->creatorNodeName = $_ENV['HOST_NAME'];
      $this->method = $post['method']; 
      $this->isDeleted = $post['method'] === 'delete' ? 'true' : 'false'; 
    }
  }

  private function createRandomHashKey(): string
  {
    return substr(md5(openssl_random_pseudo_bytes(20)), -32);
  }

  public function saveNote()
  { 
    $dataToSave = $this->getCurrentNoteData();
    unset($dataToSave['method']);
    $dataToSave = array_values($dataToSave);
    $this->note->save($dataToSave);
  }

  public function updateNote()
  {
    $dataToUpdate = array_values($this->getDataToUpdate());
    $this->note->update($dataToUpdate);
  }

  public function deleteNote(): bool
  {
    $dataToDelete = array_values($this->getDataTodelete());
    return $this->note->delete($dataToDelete);
  }

  public function fetchOneNote(): array
  {
    $id = [$this->noteHashKey];
    return $this->note->selectOne($id);
  }

  public function migrateNote(): void
  {
    $this->note->migrate();
  }

  public function fetchAllNotes(): array
  {
    return $this->note->selectAll();
  }

  public function getCurrentNoteData(): array
  {
    return [
      'note_title' => $this->noteTitle,
      'note_description' => $this->noteDescription,
      'note_hash_key' => $this->noteHashKey,
      'creator_node_name' => $this->creatorNodeName,
      'is_deleted' => $this->isDeleted,
      'method' => $this->method
    ];
  }

  private function getDataTodelete(): array
  {
    return [
      'is_deleted' => 'true',
      'note_hash_key' => $this->noteHashKey,
    ];
  }

  private function getDataToUpdate(): array
  {
    return [
      'note_title' => $this->noteTitle,
      'note_description' => $this->noteDescription,
      'note_hash_key' => $this->noteHashKey
    ];
  }
}
