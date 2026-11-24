<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/models/TabelKandidat.php';
require_once __DIR__.'/models/TabelJadwalInterview.php';
require_once __DIR__.'/views/ViewKandidat.php';
require_once __DIR__.'/views/ViewJadwalInterview.php';
require_once __DIR__.'/presenters/PresenterKandidat.php';
require_once __DIR__.'/presenters/PresenterJadwalInterview.php';

$model_kandidat = new TabelKandidat();
$view_kandidat = new ViewKandidat();
$presenter_kandidat = new PresenterKandidat($model_kandidat, $view_kandidat);

$model_jadwal_interview = new TabelJadwalInterview();
$view_jadwal_interview = new ViewJadwalInterview();
$presenter_jadwal_interview = new PresenterJadwalInterview($model_jadwal_interview, $model_kandidat, $view_jadwal_interview);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  if($_POST['page'] === 'jadwal_interview') {
    if(isset($_POST['action'])) {
      if($_POST['action'] === 'tambah') {
        $presenter_jadwal_interview->tambahJadwalInterview($_POST['kandidat_id'], $_POST['waktu'], $_POST['tempat'], $_POST['status']);
      } elseif($_POST['action'] === 'ubah') {
        $presenter_jadwal_interview->ubahJadwalInterview($_POST['id'], $_POST['kandidat_id'], $_POST['waktu'], $_POST['tempat'], $_POST['status']);
      } elseif($_POST['action'] === 'hapus') {
        $presenter_jadwal_interview->hapusJadwalInterview($_POST['id']);
      }
    }
  } else {
    if(isset($_POST['action'])) {
      if($_POST['action'] === 'tambah') {
        $presenter_kandidat->tambahKandidat($_POST['nama'], $_POST['posisi'], $_POST['domisili'], $_POST['skor_tes'], $_POST['pengalaman_tahun']);
      } elseif($_POST['action'] === 'ubah') {
        $presenter_kandidat->ubahKandidat($_POST['id'], $_POST['nama'], $_POST['posisi'], $_POST['domisili'], $_POST['skor_tes'], $_POST['pengalaman_tahun']);
      } elseif($_POST['action'] === 'hapus') {
        $presenter_kandidat->hapusKandidat($_POST['id']);
      }
    }
  }

  header("Location: index.php");
  exit();
} else {
  $screen = $_GET['screen'] ?? 'list';

  if(isset($_GET['page']) && $_GET['page'] === 'jadwal_interview') {
    if($screen === 'add') {
      echo $presenter_jadwal_interview->tampilkanFormJadwalInterview();
    } elseif($screen === 'edit' && isset($_GET['id'])) {
      echo $presenter_jadwal_interview->tampilkanFormJadwalInterview((int)$_GET['id']);
    } else {
      echo $presenter_jadwal_interview->tampilkanJadwalInterview();
    }
  } else {
    if($screen === 'add') {
      echo $presenter_kandidat->tampilkanFormKandidat();
    } elseif($screen === 'edit' && isset($_GET['id'])) {
      echo $presenter_kandidat->tampilkanFormKandidat((int)$_GET['id']);
    } else {
      echo $presenter_kandidat->tampilkanKandidat();
    }
  }
}
?>

