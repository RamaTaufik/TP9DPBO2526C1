<?php
require_once __DIR__ . '/DB.php';
require_once __DIR__ . '/KontrakModelJadwalInterview.php';
require_once __DIR__ . '/JadwalInterview.php';

class TabelJadwalInterview extends DB implements KontrakModelJadwalInterview {

  public function __construct(
    string $host = NULL,
    string $db_name = NULL,
    string $username = NULL,
    string $password = NULL
  ) {
    parent::__construct($host, $db_name, $username, $password);
  }

  private function mapRowToJadwalInterview(array $row): JadwalInterview {
    return new JadwalInterview(
      (int)$row['id'],
      (int)$row['kandidat_id'],
      $row['kandidat'] ?? NULL,
      $row['waktu'],
      $row['tempat'],
      $row['status']
    );
  }

  public function getAllJadwalInterview(): array {
    $query = "
      SELECT j.*, k.nama as kandidat
      FROM jadwal_interview j
      LEFT JOIN kandidat k ON j.kandidat_id = k.id
      ORDER BY waktu ASC, id ASC
    ";
    $this->executeQuery($query);
    $rows = $this->getAllResult();
    $list = [];

    foreach($rows as $row) {
      $list[] = $this->mapRowToJadwalInterview($row);
    }
    
    return $list;
  }

  public function getJadwalInterviewById(int $id): ?JadwalInterview {
    $query = "SELECT * FROM jadwal_interview WHERE id = :id LIMIT 1";
    $this->executeQuery($query, [':id' => $id]);
    $rows = $this->getAllResult();

    if(empty($rows)) {
      return null;
    }

    return $this->mapRowToJadwalInterview($rows[0]);
  }

  public function addJadwalInterview(int $kandidat_id, ?string $waktu, ?string $tempat, ?string $status): void {
    $query = "INSERT INTO jadwal_interview(`id`, `kandidat_id`, `waktu`, `tempat`, `status`) VALUES (NULL, ?, ?, ?, ?)";
    $this->executeQuery($query, [$kandidat_id, $waktu, $tempat, $status]);
  }

  public function updateJadwalInterview(int $id, int $kandidat_id, ?string $waktu, ?string $tempat, ?string $status): void {
    $query = "UPDATE jadwal_interview SET `kandidat_id` = ?, `waktu` = ?, `tempat` = ?, `status` = ? WHERE `id` = ?";
    $this->executeQuery($query, [$kandidat_id, $waktu, $tempat, $status, $id]);
  }

  public function deleteJadwalInterview(int $id): void {
    $query = "DELETE FROM jadwal_interview WHERE `id` = ?";
    $this->executeQuery($query, [$id]);
  }
}
?>

