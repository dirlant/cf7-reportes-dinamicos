<?php
  global $wpdb;

  /********************************************
  * Listado de Formularios con Contact Form 7
  *********************************************/
  $nameForm = $_GET['formTitle'];
  if(!empty($_GET['formTitle'])){
    $query = $wpdb->get_results(
      "SELECT *
  	     FROM camionesjac.wp_cf7dbplugin_submits
  	    WHERE form_name = '$nameForm'"
      );
  }

  /********************************************
  * Registros del formulario elegido
  *********************************************/
  if(!empty($_GET['desde'])){
    $desde = $_GET['desde'].' 00:00:00';
    $hasta = (empty($_GET['hasta'])) ? date("Y-m-d").' 23:59:59' : $_GET['hasta'].' 23:59:59';
    $query = $wpdb->get_results(
      "SELECT *
  	     FROM camionesjac.wp_cf7dbplugin_submits
  	    WHERE form_name = '$nameForm'
          AND form_date BETWEEN '$desde' AND '$hasta'"
      );
  }
?>

<?php
  $arreglo = [];
  $i = 0;
  foreach ($query as $key) {
    if ($key->field_name == 'nombre') {
      // Aumenta el contador siempre que el campo sea distinto
      $i++;
      $arreglo[$i]['date'] = date("d-m-Y", strtotime($key->form_date));
      $arreglo[$i][$key->field_name] = $key->field_value;
    }else{
      $arreglo[$i][$key->field_name] = $key->field_value;
    }
  }
  $filas = $i;
?>

<style media="screen">
table {
  display: block;
  overflow-x: auto;
  white-space: nowrap;
}
</style>
<h2 align="center">Registro del formulario:  <?php echo $nameForm ?></h2>
<table class="wp-list-table widefat striped">
  <thead>
    <form action="?page=reportes" method="get">
      <input type="hidden" name="page" value="reportes">
      <input type="hidden" name="formTitle" value="<?php echo $nameForm ?>">
      <tr>
        <th width="5%">Fecha:</th>
        <th width="10%">
          <input type="date" name="desde" value="<?php echo $_GET['desde'] ?>" required>
        </th>
        <th width="5%">Hasta:</th>
        <th width="10%">
          <input type="date" name="hasta" value="<?php echo $_GET['hasta'] ?>">
        </th>
        <th width="5%">
          <input type="submit" class="button button-primary" value="Buscar">
        </th>
        <th width="10%">
          <input type="submit" class="button button-primary" name="exportar" value="Exportar">
        </th>
        <th width="55%"></th>
      </tr>
    </form>
  </thead>
<table class="wp-list-table widefat striped">
  <thead>
    <tr>
      <th>#</th>
      <?php
        // se extraen las key del arreglo
        $titulos =  end($arreglo);
        $titulos = (array_keys($titulos));
      ?>
      <?php for ($i=0; $i < count($titulos); $i++): ?>
      <th class="manage-column"><?php echo $titulos[$i] ?></th>
      <?php endfor; ?>
    </tr>
  </thead>
  <tbody>
      <?php for ($i=1; $i <= $filas; $i++): ?>
        <tr>
          <td><?php echo $i; ?></td>
          <?php for ($j=0; $j <= count($titulos); $j++): ?>
            <td><?php echo $arreglo[$i][$titulos[$j]] ?></td>
          <?php endfor; ?>
        </tr>
      <?php endfor; ?>

  </tbody>
</table>
