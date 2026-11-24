<?php
interface KontrakPresenterJadwalInterview {
  public function tampilkanJadwalInterview(): string;
  public function tampilkanFormJadwalInterview(?int $id = NULL): string;
  public function tambahJadwalInterview(int $kandidat_id, ?string $waktu, ?string $tempat, ?string $status): void;
  public function ubahJadwalInterview(int $id, int $kandidat_id, ?string $waktu, ?string $tempat, ?string $status): void;
  public function hapusJadwalInterview(int $id): void;
}
?>
