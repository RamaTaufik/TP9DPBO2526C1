<?php
require_once __DIR__ . '/DB.php';
require_once __DIR__ . '/KontrakModel.php';
require_once __DIR__ . '/Kandidat.php';

class TabelKandidat extends DB implements KontrakModel {

  public function __construct(
    string $host = NULL,
    string $db_name = NULL,
    string $username = NULL,
    string $password = NULL
  ) {
    parent::__construct($host, $db_name, $username, $password);
  }

  private function mapRowToKandidat(array $row): Kandidat {
    return new Kandidat(
      (int)$row['id'],
      $row['nama'],
      $row['posisi'],
      $row['domisili'],
      (int)$row['skor_tes'],
      (int)$row['pengalaman_tahun']
    );
  }

  public function getAllKandidat(): array {
    $query = "SELECT * FROM kandidat ORDER BY skor_tes DESC, id ASC";
    $this->executeQuery($query);
    $rows = $this->getAllResult();
    $list = [];

    foreach($rows as $row) {
      $list[] = $this->mapRowToKandidat($row);
    }
    
    return $list;
  }

  public function getKandidatById(int $id): ?Kandidat {
    $query = "SELECT * FROM kandidat WHERE id = :id LIMIT 1";
    $this->executeQuery($query, [':id' => $id]);
    $rows = $this->getAllResult();

    if(empty($rows)) {
      return null;
    }

    return $this->mapRowToKandidat($rows[0]);
  }

  public function addKandidat(string $nama, string $posisi, string $domisili, int $skor_tes, int $pengalaman_tahun): void {
    $query = "INSERT INTO kandidat(`id`, `nama`, `posisi`, `domisili`, `skor_tes`, `pengalaman_tahun`) VALUES (NULL, ?, ?, ?, ?, ?)";
    $this->executeQuery($query, [$nama, $posisi, $domisili, $skor_tes, $pengalaman_tahun]);
  }

  public function updateKandidat(int $id, string $nama, string $posisi, string $domisili, int $skor_tes, int $pengalaman_tahun): void {
    $query = "UPDATE kandidat SET `nama` = ?, `posisi` = ?, `domisili` = ?, `skor_tes` = ?, `pengalaman_tahun` = ? WHERE `id` = ?";
    $this->executeQuery($query, [$nama, $posisi, $domisili, $skor_tes, $pengalaman_tahun, $id]);
  }

  public function deleteKandidat(int $id): void {
    $query = "DELETE FROM kandidat WHERE `id` = ?";
    $this->executeQuery($query, [$id]);
  }
}
?>

