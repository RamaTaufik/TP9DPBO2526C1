<?php
require_once __DIR__ . '/KontrakPresenter.php';
require_once __DIR__ . '/../models/KontrakModel.php';
require_once __DIR__ . '/../views/KontrakView.php';

class PresenterKandidat implements KontrakPresenter {
  private KontrakModel $model;
  private KontrakView $view;

  public function __construct(KontrakModel $model, KontrakView $view) {
    $this->model = $model;
    $this->view = $view;
  }

  /**
   * Helper untuk merakit 1 baris HTML tabel kandidat.
   * Panggil dari dalam tampilkanKandidat() saat melakukan foreach.
   */
  private function buildRowHtml(int $no, Kandidat $kandidat): string {
    $id = (int)$kandidat->getId();
    $nama = htmlspecialchars($kandidat->getNama());
    $posisi = htmlspecialchars($kandidat->getPosisi());
    $domisili = htmlspecialchars($kandidat->getDomisili());
    $skor_tes = number_format($kandidat->getSkorTes()) . ' / 100';
    $pengalaman = number_format($kandidat->getPengalamanTahun()) . ' Tahun';

    return "<tr>
      <td class='col-id'>{$no}</td>
      <td><strong>{$nama}</strong></td>
      <td>{$posisi}</td>
      <td>{$domisili}</td>
      <td>{$skor_tes}</td>
      <td>{$pengalaman}</td>
      <td class='col-actions'>
        <a href='index.php?screen=edit&id={$id}' class='btn btn-edit'>Edit</a>
        <form method='post' action='index.php' style='display:inline;' onsubmit=\"return confirm('Hapus kandidat ini?')\">
          <input type='hidden' name='action' value='hapus'>
          <input type='hidden' name='id' value='{$id}'>
          <input type='hidden' name='page' value='kandidat'>
          <button type='submit' class='btn btn-delete'>Hapus</button>
        </form>
      </td>
    </tr>";
  }

  public function tampilkanKandidat(): string {
    $listKandidat = $this->model->getAllKandidat();
    $totalKandidat = count($listKandidat);
    $rowsHtml = '';

    if(empty($listKandidat)) {
      $rowsHtml = '<tr><td colspan="7" style="text-align:center;color:#6b7280;padding:24px;">Belum ada data kandidat.</td></tr>';
    } else {
      $no = 1;

      foreach($listKandidat as $kandidat) {
        $rowsHtml .= $this->buildRowHtml($no, $kandidat);
        $no++;
      }
    }
 
    return $this->view->renderDaftar($rowsHtml, $totalKandidat);
  }

  public function tampilkanFormKandidat(?int $id = null): string {
    if($id !== null) {
      $kandidat = $this->model->getKandidatById($id);

      if($kandidat === null) {
        header("Location: index.php");
        exit();
      }

      $formData = [
        'id'              => $kandidat->getId(),
        'nama'            => $kandidat->getNama(),
        'posisi'          => $kandidat->getPosisi(),
        'domisili'        => $kandidat->getDomisili(),
        'skor_tes'         => $kandidat->getSkorTes(),
        'pengalaman_tahun' => $kandidat->getPengalamanTahun(),
      ];

      return $this->view->renderForm("Ubah Data Kandidat", "ubah", $formData);
    }
 
    return $this->view->renderForm("Tambah Kandidat Baru", "tambah", []);
  }

  public function tambahKandidat(string $nama, string $posisi, string $domisili, int $skor_tes, int $pengalaman_tahun): void {
    $skor_tes = $skor_tes < 0? 0: ($skor_tes > 100? 100: $skor_tes);
    $this->model->addKandidat($nama, $posisi, $domisili, $skor_tes, $pengalaman_tahun);

    header("Location: index.php");
    exit();
  }

  public function ubahKandidat(int $id, string $nama, string $posisi, string $domisili, int $skor_tes, int $pengalaman_tahun): void {
    $kandidat = $this->model->getKandidatById($id);

    if($kandidat === null) {
      header("Location: index.php");
      exit();
    }

    $skor_tes = $skor_tes < 0? 0: ($skor_tes > 100? 100: $skor_tes);
    $this->model->updateKandidat($id, $nama, $posisi, $domisili, $skor_tes, $pengalaman_tahun);

    header("Location: index.php");
    exit();
  }

  public function hapusKandidat(int $id): void {
    $kandidat = $this->model->getKandidatById($id);

    if($kandidat === null) {
      header("Location: index.php");
      exit();
    }

    $this->model->deleteKandidat($id);

    header("Location: index.php");
    exit();
  }
}
?>

