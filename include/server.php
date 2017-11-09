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
  posiciones_disponibles($id,$turno);
  echo mysql_insert_id();
}
function posiciones_disponibles($partida,$turno){
  $posicionescuadro=3;
  $prob=array(); //probabilidad de exito
  $disc=array(); //discriminados
  $fina=array(); //finalizados
  $validar=array(array(1,2,3),array(4,5,6),array(7,8,9),array(1,5,9),array(3,5,7),array(1,4,7),array(2,5,8),array(3,6,9));
  $result=select("select * from movimiento where id_partida=$partida");
  // error_log(print_r($result,true));
  error_log('--------------------------------------------------------------------');
  foreach ($validar as $key => $value) {
    $prev_turno=0;
    $prev_turno_suma=0;
    $suma_opcion=0;
    $discriminar=0;
    foreach ($result as $key3 => $value3) {
      $suma_opcion=0;
      foreach ($value as $key2 => $value2) {
        if ($value2==$value3['posicion']){
          $suma_opcion++;
          if ($prev_turno!=0 && $prev_turno!=$value3['turno']) {$disc[]=$key;}
          if ($prev_turno==0) $prev_turno=$value3['turno'];
          if ($prev_turno==$value3['turno']) $prev_turno_suma++;
          if ($discriminar==1) $prev_turno_suma=0;
          array_push($prob,array ("turno"=>$value3['turno'],"opcion"=>$key,"probabilidad"=>round(($prev_turno_suma*100)/$posicionescuadro)));
        }
      }
      if ($suma_opcion==3) $fina[]=$key;
    }
  }

  foreach ($prob as $key => $value) {
    if (!in_array($value['opcion'],$disc)) {
      error_log($value['turno'].' | '.$value['opcion'].' | '.$value['probabilidad']);
      // reaccion en base a posibilidad alta
      if ($value['probabilidad']=='67' && $value['turno']==$turno){
        error_log("Evaluacion de accion > ".$value['opcion']);
      }
    };
  }
  // error_log(print_r($prob[0],true));
  // error_log(print_r($validar,true));
}
function probabilidad_ganar(){

}
function probabilidad_empate(){

}
?>
