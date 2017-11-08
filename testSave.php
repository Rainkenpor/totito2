<?php
$img = $_POST['imgBase64'];

// error_log($img);
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$fileData = base64_decode($img);
//saving
if (isset($_POST['name'])){
  $fileName = 'src/'.$_POST['name'];
}else{
  $fileName = 'src/imagen.jpg';
}
file_put_contents($fileName, $fileData);

?>
