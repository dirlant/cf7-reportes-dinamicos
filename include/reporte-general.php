<?php
  global $wpdb;

  $query = $wpdb->get_results(
    "SELECT *
       FROM camionesjac.wp_posts
      WHERE post_type = 'wpcf7_contact_form'"
    );

?>
<div class="wrap">
  <h1>Reporte General</h1>
  <?php if (!isset($_GET['formTitle'])): ?>
    <table class="wp-list-table widefat striped">
      <thead>
        <tr>
          <th class="manage-column">ID</th>
          <th class="manage-column">Titulo</th>
          <th class="manage-column">Estatus</th>
          <th class="manage-column">Tipo</th>
          <th class="manage-column">Acción</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($query as $key): ?>
          <tr>
            <th class="manage-column"><?php echo $key->ID ?></th>
            <th class="manage-column"><?php echo $key->post_title ?></th>
            <th class="manage-column"><?php echo $key->post_status ?></th>
            <th class="manage-column"><?php echo $key->post_type ?></th>
            <th class="manage-column"><a href="?page=reportes&formTitle=<?php echo $key->post_title ?>" class="button button-primary">Filtrar</a></th>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <?php if (isset($_GET['formTitle'])): ?>
      <?php include('reporte-filter.php'); ?>
  <?php endif; ?>

  <?php if (isset($_GET['exportar'])): ?>

      <?php
        exportCSV($arreglo);



      ?>
  <?php endif; ?>



    <?php

    function exportCSV($array){

      ob_clean();

      header('Content-Type: text/csv');
      header('Content-Disposition: attachment;filename=' . 'exportable.csv');
      if(isset($array[1])){
          $fp = fopen('php://output', 'w');
          fputcsv($fp, array_keys($array[1]));
          foreach($array AS $values){
            fputcsv($fp, $values);
          }
          fclose($fp);
          die();
      }
      ob_flush();

  }


      // Preparando encabezado
      /*
      $row[] = array(
          "ID",
          "rut_proveedor",
          "password",
          "proveedor",
          "rut"
      );
      foreach($query as $key){
          $row[] = array(
              $key->ID,
              $key->rut_proveedor,
              $key->password,
              $key->proveedor
          );
      }
      */


      //$export = New ExportFile($row, 'archivo', '.csv');
      //return $export->exportToCSV();
      //return csvFile($row, 'archivo');

    ?>


<?php


/**
 *
 */
class ExportFile {
  public $array = array();
  function __construct($array, $nombre, $extension) {
    $this->args = $array;
    $this->nombre = $nombre;
    $this->extension = $extension;
  }

  public function exportToCSV() {
    $upload_dir = wp_upload_dir();
    $fecha = date('dmYHis');
    $filename = $upload_dir['path'] . DIRECTORY_SEPARATOR . $this->nombre.'_'. $fecha . $this->extension;
    $filename_url = $upload_dir['url']  . '/'.$this->nombre.'_'. $fecha . $this->extension;
    $content = '';
    $content .= "\xEF\xBB\xBF";
    foreach($this->args as $row) {
        $content .= implode(';', $row)."\r";
    }
    file_put_contents($filename, $content);
    return wp_safe_redirect($filename_url);
  }
}

?>
</div>
