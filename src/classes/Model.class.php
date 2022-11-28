<?php declare(strict_types=1);

class Model extends Dbh {
  private string $allColumnNames;
  private string $preparedStmtBuffer;
  private string $tableName;
  private string $mainIdColumnName;
  private string $updatableColumnsString;
  protected function __construct(array $modelSetup)
  {
    $this->dbh = (new Dbh)->connect();
    $this->allColumnNames = $modelSetup['column_names'];
    $this->tableName = $modelSetup['table_name'];
  }

  protected function insert(array $dataToInsert):void {
    $sql = "INSERT INTO " . $this->tableName . " " . $this->allColumnNames . " VALUES " . $this->preparedStmtBuffer;
    $stmt = $this->dbh->prepare($sql);
    $stmt->execute($dataToInsert);
  }

  protected function selectByMainId(string $id): array {
    $sql = "SELECT * FROM " . $this->tableName . " WHERE " . $this->mainIdColumnName . "=?";
    $stmt = $this->dbh->prepare($sql);
    $result = $stmt->execute([$id]);
    return $result;
  }

  protected function selectByTwoIds(string $id, string $secondId): array {
    $sql = "SELECT * FROM " . $this->tableName . " WHERE " . $this->mainIdColumnName . "=?" . " AND " . $this->minorIdColumnName . "=?";
    $stmt = $this->dbh->prepare($sql);
    $result = $stmt->execute([$id, $secondId]);
    return $result;
  }

  protected function selectAllAsc(): array {
    $sql = "SELECT * FROM " . $this->tableName;
    $stmt = $this->dbh->query($sql);
    $result = $stmt->fetchAll();
    return $result;
  }

  protected function selectAllDesc(): array {
    $sql = "SELECT * FROM " . $this->tableName . " ORDER BY " . $this->orderColumn . " DESC";
    $stmt = $this->dbh->query($sql);
    $result = $stmt->fetchAll();
    return $result;
  }

  protected function updateByMainId(string $id, array $data): void {
    $sql = "UPDATE " . $this->tableName . " SET " . $this->updatableColumnsString . " WHERE "
    . $this->mainIdColumnName . "=?";
    $stmt = $this->dbh->prepare($sql);
    $stmt->execute([...$data, $id]);
  }

  protected function delete($id): void {
    $sql = "DELETE FROM " . $this->tableName . " WHERE " . $this->mainIdColumnName . "=?";
    $stmt = $this->dbh->prepare($sql);
    $stmt->execute([$id]);
  }
}