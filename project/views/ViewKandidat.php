<?php
require_once __DIR__ . '/KontrakView.php';

class ViewKandidat implements KontrakView {
  private string $skinPath;
  private string $formPath;

  public function __construct(string $skinPath = '', string $formPath = '') {
    $this->skinPath = $skinPath ?: __DIR__ . '/../template/skin.html';
    $this->formPath = $formPath ?: __DIR__ . '/../template/form.html';
  }

  public function renderDaftar(string $tableRowsHtml, int $totalData): string {
    $template = file_get_contents($this->skinPath);
    $tableHeaders = '
      <tr>
        <th class="col-id">No</th>
        <th>Nama</th>
        <th>Posisi Dilamar</th>
        <th>Domisili</th>
        <th>Skor Tes</th>
        <th>Pengalaman</th>
        <th class="col-actions">Aksi</th>
      </tr>
    ';

    $tokens = [
      '{{TITLE}}'         => 'Kandidat',
      '{{TABLE_HEADERS}}' => $tableHeaders,
      '{{TABLE_ROWS}}'    => $tableRowsHtml,
      '{{TOTAL_DATA}}'    => (string)$totalData,
    ];

    return str_replace(array_keys($tokens), array_values($tokens), $template);
  }

  public function renderForm(string $title, string $action, array $formData = []): string {
    $template = file_get_contents($this->formPath);
    $formInputs = '
      <div>
        <label for="nama">Nama Kandidat</label>
        <input id="nama" name="nama" type="text" placeholder="Nama lengkap kandidat" value="'.($formData['nama'] ?? '').'" required>
      </div>

      <div>
        <label for="posisi">Posisi Dilamar</label>
        <input id="posisi" name="posisi" type="text" placeholder="Misal: Backend Developer" value="'.($formData['posisi'] ?? '').'" required>
      </div>

      <div>
        <label for="domisili">Domisili</label>
        <input id="domisili" name="domisili" type="text" placeholder="Misal: Bandung" value="'.($formData['domisili'] ?? '').'" required>
      </div>

      <div>
        <label for="skorTes">Skor Tes (0-100)</label>
        <input id="skorTes" name="skorTes" type="number" min="0" max="100" step="1" value="'.((string)($formData['skorTes'] ?? 0)).'">
      </div>

      <div class="full">
        <label for="pengalamanTahun">Pengalaman Kerja (Tahun)</label>
        <input id="pengalamanTahun" name="pengalamanTahun" type="number" min="0" step="1" value="'.($formData['pengalamanTahun'] ?? 0).'">
      </div>
    ';

    $tokens = [
      '{{FORM_TITLE}}'  => htmlspecialchars($title),
      '{{ACTION}}'      => htmlspecialchars($action),
      '{{ID}}'          => htmlspecialchars((string)($formData['id'] ?? '')),
      '{{FORM_INPUTS}}' => $formInputs
    ];

    return str_replace(array_keys($tokens), array_values($tokens), $template);
  }
}
?>
