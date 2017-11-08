<?php
$server = "localhost"; //tipo de servidor sugerencia: localhost
$user = "root"; //usuario de acceso a la base
$pass = "Walter1250"; //contrase�a de usuario de la base
$base = "totito"; //nombre de la base a utilizar
$conn  = mysql_connect($server,$user,$pass) or die ("Error conectando a la base de datos ".mysql_error());
mysql_select_db($base,$conn) or die ("Error seleccionando la base de datos ". mysql_error());


function select($query){
  $result = mysql_query($query);
  if($result){
    $columnas = mysql_num_fields($result);
    $x=0;
    while ($fetch = mysql_fetch_array($result)){
      for ($y = 0 ; $y < $columnas ; $y++){
        $arreglo[$x][mysql_field_name($result,$y)]=$fetch[$y];
      }
      $x++;
    }
    return $arreglo;
  }
}


?>
