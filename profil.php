<?php
  session_start();
  include "logsighelp.php";
  $fiokok = loadUsers("users.txt");

  if (isset($_SESSION["user"])){
      $profilkep = "img/profilpictures/default.jpg";
      $utvonal = "img/profilpictures/" . $_SESSION["user"]["felhasznalonev"];

      $kiterjesztesek = ["png", "jpg", "jpeg"];

      foreach ($kiterjesztesek as $kiterjesztes) {
        if (file_exists($utvonal . "." . $kiterjesztes)) {
          $profilkep = $utvonal . "." . $kiterjesztes;
        }
      }
    }
    if(!isset($_SESSION['user'])){
        header("Location: signlogin.php");
    }
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A felfedezésre váró képek tárháza, és cicák.">
    <meta name="author" content="Horváth Krisztián Sándor, Kurunczi Nándor">
    <meta name="keywords" content="HTML, CSS, JavaScript, Photos, Cat, Cica, Képek">
    <link rel="icon" href="img/logo.png" />
    <link rel="stylesheet" href="css/profil-style.css">
    <!-- profil -->
    <title>Project P - Profil</title>
</head>

<body>
<header>
        
        <a href="index.php"><img src="img/logot.png" alt="Project P logo" class="menu-logo"></a>
        <?php if (isset($_SESSION["user"])) { ?>
        <nav>
            <ul class="nav_links">
                <li><a href="index.php">Home</a></li>
                <li><a href="explore.php">Fedezd Fel!</a></li>
                <li><a href="creators.php">Kreátorok</a></li>
                <li><a href="profil.php" class="active">Profil</a></li>
                <li><a href="chat.php">Üzenetek</a></li>
                <li><a href="activity.php">Tevékenység</a></li>
            </ul>
        </nav>
        <form style="display: inline" action="logout.php" method="get">
            <button class="btn-hoverfinal2">Kijelentkezés</button>
        </form>
        <img src="<?php echo $profilkep; ?>" alt="Profilkép" class="profpic" />
        <?php if($_SESSION["user"]["permission"] == 'Admin'){ ?>
                <p><a href="admin.php">Admin felület</a></p>
            <?php } else{?>
            <p><a href="profil.php"><?php echo $_SESSION["user"]["felhasznalonev"]; ?></a></p>
            <?php } ?>
        <?php } ?>

    </header>

    <main>
        <div class="hero">
            <div class="form-box">
                
                <?php
                    $hiba = 0;
                    if (isset($_POST["submit-btn_pswd"])) {

                        if (!isset($_POST["jelszo"]) || trim($_POST["jelszo"]) === "" || !isset($_POST["jelszo2"]) || trim($_POST["jelszo2"]) === "") {
                            echo"<script>alert('Mindkét jelszó szükséges!')</script>";
                            $hiba = 1;
                        }

                        $jelszo = $_POST["jelszo"];
                        $jelszo2 = $_POST["jelszo2"];

                        if (strlen($jelszo) < 6) {
                            echo"<script>alert('6 karakter hosszú jelszó szükséges!')</script>";
                            $hiba = 1; 
                        }
    
                        if ($jelszo !== $jelszo2) {
                            echo"<script>alert('Nem egyezik a két jelszó!')</script>";
                            $hiba = 1;
                        }

                        foreach ($fiokok as $fiok) {
                            $felhasznalonev = $_SESSION["user"]["felhasznalonev"];

                            if ($fiok["felhasznalonev"] === $felhasznalonev && $hiba === 0) {                         
                                $passold = $_SESSION["user"]["jelszo"];
                                $passoldlen = strlen($passold);
                                $passcreateoldlen = 's:14:"felhasznalonev";s:8:"'.$_SESSION["user"]["felhasznalonev"].'";s:10:"permission";s:5:"'.$_SESSION["user"]["permission"].'";s:6:"jelszo";s:60:"'.$_SESSION["user"]["jelszo"].'";';

                                $jelszo = $_POST["jelszo"];
                                $passnew = password_hash($jelszo, PASSWORD_DEFAULT);
                                $passnewlen = strlen($passnew);
                                $passcreatenewlen = 's:14:"felhasznalonev";s:8:"'.$_SESSION["user"]["felhasznalonev"].'";s:10:"permission";s:5:"'.$_SESSION["user"]["permission"].'";s:6:"jelszo";s:60:"'.$jelszo.'";';
                                
                                $str=file_get_contents('users.txt');
                                $str=str_replace($passold, $passnew,$str);
                                file_put_contents('users.txt', $str);

                                $strr=file_get_contents('users.txt');
                                $strr=str_replace("$passcreateoldlen", "$passcreatenewlen",$strr);
                                file_put_contents('users.txt', $strr);

                                echo"<script>alert('Sikeres jelszó módosításhoz újra be kell lépned!')</script>";
                                echo"<script>window.location.href = 'logout.php';</script>";
                                break;
                                }
                        }
                    }
                    
                ?>
                <form action="profil.php" method="POST" class="input-group7">
                    <h3>Jelszó módosítás</h3>
                    <input type="password" class="input-field" name="jelszo" placeholder="Új jelszó (min 6 karakter)" required>
                    <input type="password" class="input-field" name="jelszo2" placeholder="Jelszó újra (min 6 karakter)" required>
                    <input type="submit" name="submit-btn_pswd" id="submit-btn_pswd" class="btn-hoverfinal" value="Jelszó megváltoztatása"/>
                    <input type="reset" id="submit-btn_ref" class="btn-hoverfinal" value="Jelszó mező törlése"/>
                </form>

                <?php
                    $hiba = 0;
                    if (isset($_POST["submit-btn_desc"])) {

                        if (!isset($_POST["desc"]) || trim($_POST["desc"]) === "") {
                            echo"<script>alert('Írj magadról valamit, ne hagyd ki azt a részt!')</script>";
                            $hiba = 1;
                        }

                        foreach ($fiokok as $fiok) {
                            $felhasznalonev = $_SESSION["user"]["felhasznalonev"];

                            if ($fiok["felhasznalonev"] === $felhasznalonev && $hiba === 0) {                         
                                $descold = $_SESSION["user"]["desc"];
                                $descoldlen = strlen($descold);
                                $desccreateoldlen = 's:4:"szin";s:7:"'.$_SESSION["user"]["szin"].'";s:4:"desc";s:' . $descoldlen . ":";

                                $descnew = $_POST["desc"];
                                $descnewlen = strlen($descnew);
                                $desccreatenewlen = 's:4:"szin";s:7:"'.$_SESSION["user"]["szin"].'";s:4:"desc";s:' . $descnewlen . ":";

                                
                                $str=file_get_contents('users.txt');
                                $str=str_replace($descold, $descnew,$str);
                                file_put_contents('users.txt', $str);

                                $strr=file_get_contents('users.txt');
                                $strr=str_replace("$desccreateoldlen", "$desccreatenewlen",$strr);
                                file_put_contents('users.txt', $strr);

                                echo"<script>alert('Sikeres leírás módosításhoz újra be kell lépned!')</script>";
                                echo"<script>window.location.href = 'logout.php';</script>";
                                break;
                                }
                        }
                    }
                ?>
                <form action="profil.php" method="POST" id="login" class="input-group2">
                    <h3>Leírás módosítás</h3>
                    <input type="text" class="input-field" name="desc" placeholder="Profil leírás" required>
                    <input type="submit" name="submit-btn_desc" id="submit-btn_desc" class="btn-hoverfinal" value="Leírás megváltoztatása"/>
                    <input type="reset" id="submit-btn_reff" class="btn-hoverfinal" value="Leírás mező törlése"/>
                </form>

                    <?php
                    if (isset($_POST["submit-btn_upload"])) {
                        if (!file_exists($_FILES['profile-pic']['tmp_name']) || !is_uploaded_file($_FILES['profile-pic']['tmp_name'])) 
                        {
                            $hiba = 1;
                            echo"<script>alert('Nincs fájl feltötlve!')</script>";
                        }
                        uploadProfilePicture($_SESSION["user"]["felhasznalonev"]);

                        $kit = strtolower(pathinfo($_FILES["profile-pic"]["name"], PATHINFO_EXTENSION));
                        $utvonal = "img/profilpictures/" . $_SESSION["user"]["felhasznalonev"] . "." . $kit;


                        if ($hiba === 0) {
                        if ($utvonal !== $profilkep) {
                            unlink($profilkep);
                            }
                            echo"<script>alert('Sikeres profilkép módosítás! Ha nem jelenik meg akkor CTRL + F5! :)')</script>";
                            echo"<script>window.location.href = 'profil.php';</script>";
                        }
                    }
                    ?>
                    <br>
                <form action="profil.php" id="register" class="input-group" method="POST" enctype="multipart/form-data">
                    <h3>Profilkép módosítás</h3>
                    <input type="text" class="input-field" placeholder="Profil kép feltöltés" disabled>
                    <input type="file" name="profile-pic" accept="image/*"/>
                    <input type="submit" name="submit-btn_upload" class="btn-hoverfinal" value="Profilkép módosítása"/>
                    <input type="reset" id="submit-btn_refff" class="btn-hoverfinal" value="Profilkép mező törlése"/>
                </form>
            </div>
            <?php
            if (isset($_POST["submit_delete"])) {
                            foreach ($fiokok as $fiok) {

                                $deletefelhasznalo = $_SESSION["user"]["felhasznalonev"];
                                if ($fiok["felhasznalonev"] === $deletefelhasznalo ) {
                                    echo"<script>alert('Sikeres törlés, köszönjük hogy itt voltál!')</script>";
                                    $fullnamelen = strlen($fiok["fullname"]);
                                    $felhasznalolen = strlen($fiok["felhasznalonev"]);
                                    $permissionlen = strlen($fiok["permission"]);
                                    $jelszolen = strlen($fiok["jelszo"]);
                                    $nemlen = strlen($fiok["nem"]);
                                    $szinlen = strlen($fiok["szin"]);
                                    $desclen = strlen($fiok["desc"]);

                                    $useroldlen = 'a:7:{s:8:"fullname";s:'.$fullnamelen.':"'.$fiok["fullname"].'";s:14:"felhasznalonev";s:'.$felhasznalolen.':"'.$fiok["felhasznalonev"].'";s:10:"permission";s:'.$permissionlen.':"'.$fiok["permission"].'";s:6:"jelszo";s:'.$jelszolen.':"'.$fiok["jelszo"].'";s:3:"nem";s:'.$nemlen.':"'.$fiok["nem"].'";s:4:"szin";s:'.$szinlen.':"'.$fiok["szin"].'";s:4:"desc";s:'.$desclen.':"'.$fiok["desc"].'";}';
 
                                    $data = file("users.txt");
                                    $out = array();
                                   
                                    foreach($data as $line) {
                                        if(trim($line) != $useroldlen) {
                                            $out[] = $line;
                                        }
                                    }
                                   
                                    $fp = fopen("users.txt", "w+");
                                    flock($fp, LOCK_EX);
                                    foreach($out as $line) {
                                        fwrite($fp, $line);
                                    }
                                    flock($fp, LOCK_UN);
                                    fclose($fp);  


                                    
                                    echo"<script>window.location.href = 'logout.php';</script>";
                                    break;
                                    }
                            }
                        }

                    ?>
            <form action="profil.php" method="POST" id="delete" class="input-group6">
                    <h3>Felhasználó törlése</h3>
                    <input type="submit" name="submit_delete" id="submit_delete" class="btn-hoverfinalred" value="Törlés!"/>
            </form>
        </div>
    </main>
    <footer>
        <div class="footer-bottom">
            <p>copyright &copy; <a href="#">Team Duzzanat ⛽️</a> </p>
            <div class="footer-menu">
                <ul class="f-menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="explore.php">Fedezd Fel!</a></li>
                    <li><a href="creators.php">Kreátorok</a></li>
                    <?php if (isset($_SESSION["user"])) { ?>
                    <li><a href="profil.php">Profil</a></li>
                    <li><a href="chat.php">Üzenetek</a></li>
                    <li><a href="activity.php">Tevékenység</a></li>
                    <?php if($_SESSION["user"]["permission"] == 'Admin'){ ?>
                    <li><a href="admin.php">Admin felület</a></li>
                    <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </footer>
    <script src="script/script.js"></script>
</body>

</html>