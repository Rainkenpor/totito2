<?php
include('connection.php');

switch ($_POST['opcion']) {
  case 'crear_partida':
    crear_partida($conn);
    break;
  case 'movimiento_partida':
    movimiento_partida($conn);
    break;
  default:
    # code...
    break;
}

function crear_partida($conn){
		$conn->multi_query("insert partida (status) values (1)");
		echo $conn->insert_id;
}
function movimiento_partida($conn){
  $id=$_POST['id'];
  $posicion=$_POST['posicion'];
  $turno=$_POST['turno'];
  $conn->multi_query("insert movimiento (id_partida,posicion,turno) values ($id,$posicion,$turno)");
  $posiciones=select("select * from movimiento where id_partida=$id");
  error_log("select * from movimiento where id_partida=$id");

  foreach ($posiciones as $key => $value) {
    $posiciones2[]=json_decode($value,true);
  }
  error_log(print_r($posiciones2,true));
  $result=posiciones_disponibles($posiciones2,$turno);
  echo json_encode($result);//  mysql_insert_id();
}

function posiciones_disponibles($posiciones,$turno){
  $posicionescuadro=3;
  $prob=array(); //probabilidad de exito
  $disc=array(); //discriminados
  $fina=array(); //finalizados
  $validar=array(array(1,2,3),array(4,5,6),array(7,8,9),array(1,5,9),array(3,5,7),array(1,4,7),array(2,5,8),array(3,6,9));
  $disponible=$validar;

  foreach ($validar as $key => $value) {
    $prev_turno=0;
    $prev_turno_suma=0;
    $suma_opcion=0;
    $discriminar=0;
    foreach ($posiciones as $key3 => $value3) {
      $suma_opcion=0;
      foreach ($value as $key2 => $value2) {
        if ($value2==$value3['posicion']){
          // eliminacion de disponible
          // var index = $disponible[$key].indexOf(5);
          if (($key_elim = array_search($value2, $disponible[$key])) !== false) {
              array_splice($disponible[$key], $key_elim, 1);
          }

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

// error_log(print_r($disponible,true));
// turno inverso (turno actual)
if ($turno==1) $turnoinv=2;
if ($turno==2) $turnoinv=1;

$result=array();
  foreach ($prob as $key => $value) {
    if (!in_array($value['opcion'],$disc)) {
      error_log($value['turno'].' | '.$value['opcion'].' | '.$value['probabilidad']);
      $result['opciones'][]=$value['turno'].' | '.$value['opcion'].' | '.$value['probabilidad'];
      if ($value['probabilidad']==100){
        $result['ganador']=$value['turno'];
        break;
      }else {
        $result['ganador']=0;
      }
      // Viables
      if ($value['turno']==$turnoinv){
        foreach ($disponible[$value['opcion']] as $key2 => $value2) {
          $result['viables'][]=$value2;
        }
      }
      // reaccion en base a posibilidad alta
      if ($value['probabilidad']=='67' && $value['turno']==$turno){
        // error_log("Probabilidad jugada ganadora del contricante > ".$value['opcion']);
        $result['contricante'][]=$disponible[$value['opcion']];
      }
      if ($value['probabilidad']=='67' && $value['turno']==$turnoinv){
        // error_log("Probabilidad jugada ganadora > ".$value['opcion']);
        $result['movimientos'][]=$disponible[$value['opcion']][0];
      }
    }
  }
  // posiciones_disponibles
  foreach ($disponible as $key => $value) {
    foreach ($value as $key2 => $value2) {
      $result['disponibles'][]=$value2;
    }
  }
  return $result;
  // error_log(print_r($prob[0],true));
  // error_log(print_r($validar,true));
}
?>
