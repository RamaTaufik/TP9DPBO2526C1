<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/models/TabelKandidat.php';
require_once __DIR__.'/views/ViewKandidat.php';
require_once __DIR__.'/presenters/PresenterKandidat.php';

$model = new TabelKandidat('localhost', 'db_mvp_kandidat', 'root', '');
$view = new ViewKandidat();
$presenter = new PresenterKandidat($model, $view);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // TODO: Tangani $_POST['action'] untuk 'tambah', 'ubah', dan 'hapus'
  header("Location: index.php");
  exit();
} else {
  $screen = $_GET['screen'] ?? 'list';
  if ($screen === 'add') {
    echo $presenter->tampilkanFormKandidat();
  } elseif ($screen === 'edit' && isset($_GET['id'])) {
    echo $presenter->tampilkanFormKandidat((int)$_GET['id']);
  } else {
    echo $presenter->tampilkanKandidat();
  }
}
?>

