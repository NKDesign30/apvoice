<?php
// Sicherheitsüberprüfung
if (!current_user_can('manage_options')) {
  return;
}

// Prüfung, ob eine Datei hochgeladen wurde
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES['hcp_groups_file'])) {
  // Datei-Verarbeitungsfunktion aufrufen
  hcp_groups_process_file($_FILES['hcp_groups_file']);
}

// Formular für Datei-Upload
?>
<h1>HCP Groups: CSV-Upload</h1>
<form method="post" action="" enctype="multipart/form-data">
  <input type="file" name="hcp_groups_file" required />
  <input type="submit" value="Upload CSV" class="button button-primary" />
</form>