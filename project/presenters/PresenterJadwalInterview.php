<?php
require_once __DIR__ . '/KontrakPresenterJadwalInterview.php';
require_once __DIR__ . '/../models/KontrakModelJadwalInterview.php';
require_once __DIR__ . '/../models/KontrakModelKandidat.php';
require_once __DIR__ . '/../views/KontrakViewJadwalInterview.php';

class PresenterJadwalInterview implements KontrakPresenterJadwalInterview {
  private KontrakModelJadwalInterview $model;
  private KontrakModelKandidat $model_kandidat;
  private KontrakViewJadwalInterview $view;

  public function __construct(KontrakModelJadwalInterview $model, KontrakModelKandidat $model_kandidat, KontrakViewJadwalInterview $view) {
    $this->model = $model;
    $this->model_kandidat = $model_kandidat;
    $this->view = $view;
  }

  /**
   * Helper untuk merakit 1 baris HTML tabel kandidat.
   * Panggil dari dalam tampilkanJadwalInterview() saat melakukan foreach.
   */
  private function buildRowHtml(int $no, JadwalInterview $jadwal_interview): string {
    $id = (int)$jadwal_interview->getId();
    $kandidat = htmlspecialchars($jadwal_interview->getKandidat());
    $waktu = htmlspecialchars($jadwal_interview->getWaktu() ?? '-');
    $tempat = htmlspecialchars($jadwal_interview->getTempat() ?? '-');
    $status = htmlspecialchars($jadwal_interview->getStatus() ?? '-');

    return "<tr>
      <td class='col-id'>{$no}</td>
      <td><strong>{$kandidat}</strong></td>
      <td>{$waktu}</td>
      <td>{$tempat}</td>
      <td>{$status}</td>
      <td class='col-actions'>
        <a href='index.php?page=jadwal_interview&screen=edit&id={$id}' class='btn btn-edit'>Edit</a>
        <form method='post' action='index.php' style='display:inline;' onsubmit=\"return confirm('Hapus jadwal interview ini?')\">
          <input type='hidden' name='action' value='hapus'>
          <input type='hidden' name='id' value='{$id}'>
          <input type='hidden' name='page' value='jadwal_interview'>
          <button type='submit' class='btn btn-delete'>Hapus</button>
        </form>
      </td>
    </tr>";
  }

  public function tampilkanJadwalInterview(): string {
    $listJadwalInterview = $this->model->getAllJadwalInterview();
    $totalJadwalInterview = count($listJadwalInterview);
    $rowsHtml = '';

    if(empty($listJadwalInterview)) {
      $rowsHtml = '<tr><td colspan="6" style="text-align:center;color:#6b7280;padding:24px;">Belum ada data kandidat.</td></tr>';
    } else {
      $no = 1;

      foreach($listJadwalInterview as $jadwal_interview) {
        $rowsHtml .= $this->buildRowHtml($no, $jadwal_interview);
        $no++;
      }
    }
 
    return $this->view->renderDaftar($rowsHtml, $totalJadwalInterview);
  }

  public function tampilkanFormJadwalInterview(?int $id = NULL): string {
    $listKandidat = $this->model_kandidat->getAllKandidat();
    $kandidatOptionHtml = '';

    if($id !== null) {
      $jadwal_interview = $this->model->getJadwalInterviewById($id);

      if($jadwal_interview === null) {
        header("Location: index.php?page=jadwal_interview");
        exit();
      }

      foreach($listKandidat as $kandidat) {
        $kandidatOptionHtml .= '<option value="'.$kandidat->getId().'"'.($kandidat->getId() === $jadwal_interview->getKandidatId()? ' selected': '').'>'.$kandidat->getNama().'</option>';
      }

      $formData = [
        'id'          => $jadwal_interview->getId(),
        'kandidat_id' => $jadwal_interview->getKandidatId(),
        'waktu'       => $jadwal_interview->getWaktu(),
        'tempat'      => $jadwal_interview->getTempat(),
        'status'      => $jadwal_interview->getStatus(),
      ];

      return $this->view->renderForm("Ubah Data Jadwal Interview", "ubah", $kandidatOptionHtml, $formData);
    }

    foreach($listKandidat as $kandidat) {
      $kandidatOptionHtml .= '<option value="'.$kandidat->getId().'">'.$kandidat->getNama().'</option>';
    }
 
    return $this->view->renderForm("Tambah Jadwal Interview Baru", "tambah", $kandidatOptionHtml, []);
  }

  public function tambahJadwalInterview(int $kandidat_id, ?string $waktu, ?string $tempat, ?string $status): void {
    $kandidat = $this->model_kandidat->getKandidatById($kandidat_id);

    if(
      $kandidat === null ||
      (!empty($tempat) && $tempat !== 'kantor' && $tempat !== 'online') ||
      (!empty($status) && $status !== 'pending' && $status !== 'ditolak' && $status !== 'dipertimbangkan' && $status !== 'diterima')
    ) {
      header("Location: index.php?page=jadwal_interview");
      exit();
    }

    $waktu = empty($waktu)? NULL: $waktu;
    $tempat = empty($tempat)? NULL: $tempat;
    $status = empty($status)? NULL: $status;
    $this->model->addJadwalInterview($kandidat_id, $waktu, $tempat, $status);

    header("Location: index.php?page=jadwal_interview");
    exit();
  }

  public function ubahJadwalInterview(int $id, int $kandidat_id, ?string $waktu, ?string $tempat, ?string $status): void {
    $jadwal_interview = $this->model->getJadwalInterviewById($id);

    if($jadwal_interview === null) {
      header("Location: index.php?page=jadwal_interview");
      exit();
    }

    $kandidat = $this->model_kandidat->getKandidatById($kandidat_id);

    if(
      $kandidat === null ||
      (!empty($tempat) && $tempat !== 'kantor' && $tempat !== 'online') ||
      (!empty($status) && $status !== 'pending' && $status !== 'ditolak' && $status !== 'dipertimbangkan' && $status !== 'diterima')
    ) {
      header("Location: index.php?page=jadwal_interview");
      exit();
    }

    $this->model->updateJadwalInterview($id, $kandidat_id, $waktu, $tempat, $status);

    header("Location: index.php?page=jadwal_interview");
    exit();
  }

  public function hapusJadwalInterview(int $id): void {
    $jadwal_interview = $this->model->getJadwalInterviewById($id);

    if($jadwal_interview === null) {
      header("Location: index.php?page=jadwal_interview");
      exit();
    }

    $this->model->deleteJadwalInterview($id);

    header("Location: index.php?page=jadwal_interview");
    exit();
  }
}
?>

