<?php
include('connection.php');

switch ($_POST['opcion']) {
  case 'crear_partida':
    crear_partida();
    break;
  case 'movimiento_partida':
    movimiento_partida();
    break;
  default:
    # code...
    break;
}

function crear_partida(){
		$resultado=mysql_query("insert partida (status) values (1)");
		echo mysql_insert_id();
}
function movimiento_partida(){
  $id=$_POST['id'];
  $posicion=$_POST['posicion'];
  $turno=$_POST['turno'];
  $resultado=mysql_query("insert movimiento (id_partida,posicion,turno) values ($id,$posicion,$turno)");
  echo mysql_insert_id();
}
?>
