<?php
/**
 * Kontrak View (Strict Passive View)
 * View tidak mengenal entitas domain, tidak melakukan loop, dan tidak menghitung agregat.
 */
interface KontrakViewJadwalInterview {
  public function renderDaftar(string $tableRowsHtml, int $totalData): string;
  public function renderForm(string $title, string $action, string $kandidatOptionHtml, array $formData = []): string;
}
?>
