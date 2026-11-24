<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/models/TabelKandidat.php';
require_once __DIR__.'/views/ViewKandidat.php';
require_once __DIR__.'/presenters/PresenterKandidat.php';

$model_kandidat = new TabelKandidat();
$view_kandidat = new ViewKandidat();
$presenter_kandidat = new PresenterKandidat($model_kandidat, $view_kandidat);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['page']) && $_POST['page'] === 'kandidat') {
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

  if($screen === 'add') {
    echo $presenter_kandidat->tampilkanFormKandidat();
  } elseif($screen === 'edit' && isset($_GET['id'])) {
    echo $presenter_kandidat->tampilkanFormKandidat((int)$_GET['id']);
  } else {
    echo $presenter_kandidat->tampilkanKandidat();
  }
}
?>

