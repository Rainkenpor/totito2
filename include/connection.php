<?php
$server = "localhost"; //tipo de servidor sugerencia: localhost
$user = "root"; //usuario de acceso a la base
$pass = "Walter1250"; //contrase�a de usuario de la base
$base = "totito"; //nombre de la base a utilizar
$conn = new mysqli($server, $user, $pass, $base);
// Check connection
if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}


function select($query){
  // $result = mysql_query($query);
 global $conn;

  if ($conn->multi_query($query)){
      if ($result=$conn->store_result()){
        while($row=$result->fetch_assoc()){
          $data[] = json_encode($row);
          $v_encontrado=1;
        }
        $result->free();
      }
    }
    if ($v_encontrado==0){
      return 0;
    }else {
      return $data;
    }

  // $conn->multi_query(
  // if($result){
  //   $columnas = mysql_num_fields($result);
  //   $x=0;
  //   while ($fetch = mysql_fetch_array($result)){
  //     for ($y = 0 ; $y < $columnas ; $y++){
  //       $arreglo[$x][mysql_field_name($result,$y)]=$fetch[$y];
  //     }
  //     $x++;
  //   }
  //   return $arreglo;
  // }
}



?>
