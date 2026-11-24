<?php
class JadwalInterview {
  private ?int $id;
  private int $kandidat_id;
  private ?string $kandidat;
  private ?string $waktu;
  private ?string $tempat;
  private ?string $status;

  public function __construct(
    ?int $id,
    int $kandidat_id,
    ?string $kandidat,
    ?string $waktu,
    ?string $tempat,
    ?string $status
  ) {
    $this->id = $id;
    $this->kandidat_id = $kandidat_id;
    $this->kandidat = $kandidat;
    $this->waktu = $waktu;
    $this->tempat = $tempat;
    $this->status = $status;
  }

  public function getId(): ?int { return $this->id; }
  public function getKandidatId(): int { return $this->kandidat_id; }
  public function getKandidat(): ?string { return $this->kandidat; }
  public function getWaktu(): ?string { return $this->waktu; }
  public function getTempat(): ?string { return $this->tempat; }
  public function getStatus(): ?string { return $this->status; }

  public function setKandidatId(int $kandidat_id): void { $this->kandidat_id = $kandidat_id; }
  public function setKandidat(?string $kandidat): void { $this->kandidat = $kandidat; }
  public function setWaktu(?string $waktu): void { $this->waktu = $waktu; }
  public function setTempat(?string $tempat): void { $this->tempat = $tempat; }
  public function setStatus(?string $status): void { $this->status = $status; }
}
?>
