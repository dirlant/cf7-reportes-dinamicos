<?php

require_once 'functions.php';

// Inicializando el campo restante en la base de datos
global $wpdb;
// Aca se verifica si un campo existe
$row = $wpdb->get_row(
  "SELECT *
     FROM ".$wpdb->prefix."cf7dbplugin_submits
     LIMIT 1"
  );

if(!isset($row->form_date)){
  $query = $wpdb->get_results(
    "ALTER TABLE ".$wpdb->prefix."cf7dbplugin_submits
             ADD  form_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP"
    );

  echo 'Bd Creada';
}



?>
