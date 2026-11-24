<?php
class Kandidat {
  private ?int $id;
  private string $nama;
  private string $posisi;
  private string $domisili;
  private int $skor_tes;
  private int $pengalaman_tahun;

  public function __construct(
    ?int $id,
    string $nama,
    string $posisi,
    string $domisili,
    int $skor_tes,
    int $pengalaman_tahun
  ) {
    $this->id = $id;
    $this->nama = $nama;
    $this->posisi = $posisi;
    $this->domisili = $domisili;
    $this->skor_tes = $skor_tes;
    $this->pengalaman_tahun = $pengalaman_tahun;
  }

  public function getId(): ?int { return $this->id; }
  public function getNama(): string { return $this->nama; }
  public function getPosisi(): string { return $this->posisi; }
  public function getDomisili(): string { return $this->domisili; }
  public function getSkorTes(): int { return $this->skor_tes; }
  public function getPengalamanTahun(): int { return $this->pengalaman_tahun; }

  public function setNama(string $nama): void { $this->nama = $nama; }
  public function setPosisi(string $posisi): void { $this->posisi = $posisi; }
  public function setDomisili(string $domisili): void { $this->domisili = $domisili; }
  public function setSkorTes(int $skor_tes): void { $this->skor_tes = $skor_tes; }
  public function setPengalamanTahun(int $pengalaman_tahun): void { $this->pengalaman_tahun = $pengalaman_tahun; }
}
?>
