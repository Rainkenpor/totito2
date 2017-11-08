<?php
if(isset( $_FILES["imagen"])) {
  // echo $_FILES["imagen"]["name"];
  $imageFileType = pathinfo(basename($_FILES["imagen"]["name"]),PATHINFO_EXTENSION);
  $target_dir = "src/";
  $target_file = $target_dir . $_POST['name'].'.'.$imageFileType;

  // echo $target_file;
  $uploadOk=1;

    $check = getimagesize($_FILES["imagen"]["tmp_name"]);
    if($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        // $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    if ($_FILES["imagen"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }

    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            // echo "The file ". basename( $_FILES["imagen"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
