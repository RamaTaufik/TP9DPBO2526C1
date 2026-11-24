<?php
interface KontrakPresenterKandidat {
  public function tampilkanKandidat(): string;
  public function tampilkanFormKandidat(?int $id = NULL): string;
  public function tambahKandidat(string $nama, string $posisi, string $domisili, int $skor_tes, int $pengalaman_tahun): void;
  public function ubahKandidat(int $id, string $nama, string $posisi, string $domisili, int $skor_tes, int $pengalaman_tahun): void;
  public function hapusKandidat(int $id): void;
}
?>
