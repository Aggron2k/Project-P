<?php

function loadPhoto($path) {
    $kepek = [];

    $file = fopen($path, "r");
    if ($file === FALSE)
      die("HIBA: A fájl megnyitása nem sikerült!");

    while (($line = fgets($file)) !== FALSE) {
      $img = unserialize($line);
      $kepek[] = $img;
    }

    fclose($file);
    return $kepek;
}

function loadMessages($path) {
  $uzenetek = [];

  $file = fopen($path, "r");
  if ($file === FALSE)
    die("HIBA: A fájl megnyitása nem sikerült!");

  while (($line = fgets($file)) !== FALSE) {
    $uzenet = unserialize($line);
    $uzenetek[] = $uzenet;
  }

  fclose($file);
  return $uzenetek;
}
?>