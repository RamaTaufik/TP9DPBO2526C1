<?php
require_once __DIR__ . '/KontrakViewJadwalInterview.php';

class ViewJadwalInterview implements KontrakViewJadwalInterview {
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
        <th>Kandidat</th>
        <th>Waktu</th>
        <th>Tempat</th>
        <th>Status</th>
        <th class="col-actions">Aksi</th>
      </tr>
    ';

    $tokens = [
      '{{TITLE}}'         => 'Jadwal Interview',
      '{{PAGE}}'          => 'jadwal_interview',
      '{{TABLE_HEADERS}}' => $tableHeaders,
      '{{TABLE_ROWS}}'    => $tableRowsHtml,
      '{{TOTAL_DATA}}'    => (string)$totalData,
    ];

    return str_replace(array_keys($tokens), array_values($tokens), $template);
  }

  public function renderForm(string $title, string $action, string $kandidatOptionHtml, array $formData = []): string {
    $template = file_get_contents($this->formPath);
    $selected_kandidat = isset($formData['kandidat_id'])? $formData['kandidat_id']: '';
    $selected_tempat = isset($formData['tempat'])? $formData['tempat']: '';
    $selected_status = isset($formData['status'])? $formData['status']: '';
    $formInputs = '
      <div>
        <label for="kandidat_id">Kandidat</label>
        <select id="kandidat_id" name="kandidat_id" required>
          <option value="">Pilih kandidat</option>
          '.$kandidatOptionHtml.'
        </select>
      </div>

      <div>
        <label for="waktu">Waktu</label>
        <input id="waktu" name="waktu" type="datetime-local" value="'.($formData['waktu'] ?? '').'">
      </div>

      <div>
        <label for="tempat">Tempat</label>
        <select id="tempat" name="tempat">
          <option value="">Pilih tempat</option>
          <option value="kantor"'.($selected_tempat === 'kantor'? ' selected': '').'>Di kantor</option>
          <option value="online"'.($selected_tempat === 'online'? ' selected': '').'>Online</option>
        </select>
      </div>

      <div>
        <label for="status">Status</label>
        <select id="status" name="status">
          <option value="">Pilih status</option>
          <option value="pending"'.($selected_status === 'pending'? ' selected': '').'>Pending</option>
          <option value="ditolak"'.($selected_status === 'ditolak'? ' selected': '').'>Ditolak</option>
          <option value="dipertimbangkan"'.($selected_status === 'dipertimbangkan'? ' selected': '').'>Dipertimbangkan</option>
          <option value="diterima"'.($selected_status === 'diterima'? ' selected': '').'>Diterima</option>
        </select>
      </div>
    ';

    $tokens = [
      '{{FORM_TITLE}}'  => htmlspecialchars($title),
      '{{ACTION}}'      => htmlspecialchars($action),
      '{{ID}}'          => htmlspecialchars((string)($formData['id'] ?? '')),
      '{{PAGE}}'        => 'jadwal_interview',
      '{{FORM_INPUTS}}' => $formInputs
    ];

    return str_replace(array_keys($tokens), array_values($tokens), $template);
  }
}
?>
