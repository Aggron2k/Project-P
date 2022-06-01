<?php
session_start();
include "logsighelp.php";

$felhasznalonev = $_SESSION["user"]["felhasznalonev"];
$tema = $_POST["tema"];

$target_dir = "img/explore/";
$target_file = $target_dir . basename($_FILES["imgupload-btn"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if (file_exists($target_file)) {
  echo"<script>alert('Ez a file már létezik.')</script>";
  $uploadOk = 0;
  echo"<script>window.location = 'explore.php'</script>";
}

if ($_FILES["imgupload-btn"]["size"] > 2000000) {
  echo"<script>alert('Ez a file túl nagy :/')</script>";
  $uploadOk = 0;
  echo"<script>window.location = 'explore.php'</script>";
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo"<script>alert('Csak JPG, JPEG, PNG vagy GIF filet tudsz feltölteni.')</script>";
  $uploadOk = 0;
  echo"<script>window.location = 'explore.php'</script>";
}

if ($uploadOk == 0) {
  echo"<script>alert('Sikertelen feltötlés.')</script>";
  echo"<script>window.location = 'explore.php'</script>";
} else {
  if (move_uploaded_file($_FILES["imgupload-btn"]["tmp_name"], $target_file)) {
    $datum = date("Y.m.d");
    $kepek[] = ["felhasznalonev" => $felhasznalonev, "tema" => $tema, "kepnev" => $target_file, "datum" => $datum];

      $file = fopen("kepek.txt", "a");
      if ($file === FALSE)
        die("HIBA: A fájl megnyitása nem sikerült!");
  
      foreach($kepek as $kep) {
        $serialized_img = serialize($kep);
        fwrite($file, $serialized_img . "\n");
      }
      fclose($file);

    $siker = TRUE;
    echo"<script>alert('Sikeres feltötlés! :)')</script>";
    if(isset($siker) && $siker === TRUE){
      echo"<script>window.location = 'explore.php'</script>";
    }
  } else {
    $siker = FALSE;
  echo"<script>alert('Egy hiba során sikertelen a feltöltés.')</script>";
  echo"<script>window.location = 'explore.php'</script>";
  }
}
?>