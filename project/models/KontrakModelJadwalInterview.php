<?php
interface KontrakModelJadwalInterview {
  /**
   * Mengambil seluruh data jadwal interview sebagai array objek JadwalInterview.
   * @return JadwalInterview[]
   */
  public function getAllJadwalInterview(): array;

  /**
   * Mengambil satu data jadwal interview berdasarkan ID.
   */
  public function getJadwalInterviewById(int $id): ?JadwalInterview;

  public function addJadwalInterview(int $kandidat_id, ?string $waktu, ?string $tempat, ?string $status): void;
  public function updateJadwalInterview(int $id, int $kandidat_id, ?string $waktu, ?string $tempat, ?string $status): void;
  public function deleteJadwalInterview(int $id): void;
}
?>
