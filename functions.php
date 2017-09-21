<?php

  if(!function_exists("wpks_cf7_reportes_dinamicos")){
  	add_action( 'admin_menu', 'wpks_cf7_reportes_dinamicos');
  	function wpks_cf7_reportes_dinamicos(){
  	  add_menu_page($page_title = 'Reportes', $menu_title = 'Reportes', $capability = 'administrator', $menu_slug = 'reportes', $function = 'reporte_general', $icon_url = 'dashicons-dashboard', $position = 120);
  	}
  	function reporte_general(){
  	  include('include/reporte-general.php');
  	}
  }

  function wpks_exportCSV($array){
    ob_clean();
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=' . 'reporte.csv');
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


?>
