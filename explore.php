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
    <link rel="stylesheet" href="css/style.css">
    <!-- explore -->
    <title>Project P - Explore</title>
</head>

<body>
    <header>
        
        <a href="index.php"><img src="img/logot.png" alt="Project P logo" class="menu-logo"></a>
        <?php if (isset($_SESSION["user"])) { ?>
        <nav>
            <ul class="nav_links">
                <li><a href="index.php">Home</a></li>
                <li><a href="explore.php" class="active">Fedezd Fel!</a></li>
                <li><a href="creators.php">Kreátorok</a></li>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="chat.php">Üzenetek</a></li>
                <li><a href="activity.php">Tevékenység</a></li>
            </ul>
        </nav>
        <form style="display: inline" action="logout.php" method="get">
            <button class="btn-hoverfinal">Kijelentkezés</button>
        </form>
        <img src="<?php echo $profilkep; ?>" alt="Profilkép" class="profpic" />
        <?php if($_SESSION["user"]["permission"] == 'Admin'){ ?>
                <p><a href="admin.php">Admin felület</a></p>
            <?php } else{?>
            <p><a href="profil.php"><?php echo $_SESSION["user"]["felhasznalonev"]; ?></a></p>
            <?php } ?>

        <?php } else { ?>
        <nav>
            <ul class="nav_links" style="margin-right: 250px">
                <li><a href="index.php">Home</a></li>
                <li><a href="explore.php" class="active">Fedezd Fel!</a></li>
                <li><a href="creators.php">Kreátorok</a></li>
            </ul>
        </nav>
        <form style="display: inline" action="signlogin.php" method="get">
            <button class="btn-hoverfinal">Bejelentkezés Regisztráció</button>
        </form>
        <?php } ?>

    </header>

    <main>
        <div id="showcase" class="grid">
            <div class="bg-image_thr"></div>
            <div class="content-wrap">
                <h1><em>Fedezd fel</em> az oldal legjobb képeit!</h1>
                <hr>
                <p>Téma szerint szeretnéd a legjobb képeket látni, itt a lehetőség a folyamatosan bövűlő szűrönkben.</p>
            </div>
            <form action="explore.php" method="post">
            <table class="tg">
                <thead>
                    <tr>
                        <td class="tg-0lax"><input type="submit" name ="autok" class="btn-hoverfinal" value="Autok"></td>
                        <td class="tg-0lax"><input type="submit" name ="tajkep" class="btn-hoverfinal" value="Tájkép"></td>
                        <td class="tg-0lax"><input type="submit" name ="cica" class="btn-hoverfinal" value="Cica"></td>
                        <td class="tg-0lax"><input type="submit" name ="etel" class="btn-hoverfinal" value="Étel"></td>
                        <td class="tg-0lax"><input type="submit" name ="divat" class="btn-hoverfinal" value="Divat"></td>
                        <td class="tg-0lax"><input type="submit" name ="osszes" class="btn-hoverfinal" value="Összes"></td>
                    </tr>
                </thead>
            </table>
            </form>
            <?php if (isset($_SESSION["user"])) {
            if ($_SESSION["user"]["permission"] == 'Admin' || $_SESSION["user"]["permission"] == 'Kreátor') { ?>
            <p>Kreátorként lehetőséged van új képet feltőlteni, próbáld ki!</p>
            <div class="img-up">
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="imgupload-btn" accept="image/*"/>
                    Téma:
                    <select name="tema" required multiple>
                        <option value="autok">Autok</option>
                        <option value="tajkep">Tájkép</option>
                        <option value="cica">Cica</option>
                        <option value="etel">Étel</option>
                        <option value="divat">Divat</option>
                    </select>
                    <input type="submit" name="upload-btn" class="btn-hoverfinal" value="Kép feltöltése"/>
                </form>
            </div>
            <?php } else {?>
            <p>Légy kreátor hogy felölthess képeket!</p>
            <div class="img-up">
                <?php
                    if(isset($_POST['give_perm'])) {
                        foreach ($fiokok as $fiok) {
                            $felhasznalonev = $_SESSION["user"]["felhasznalonev"];

                            if ($fiok["felhasznalonev"] === $felhasznalonev) {                         
                                $permold = $_SESSION["user"]["permission"]; /*FELHASZANLO*/ 
                                $permoldlen = strlen($permold); 
                                $permcreateoldlen = '"'.$_SESSION["user"]["felhasznalonev"].'";s:10:"permission";s:'.$permoldlen.':"'.$permold.'";';

                                /*"permission";s:8:"Kreátor";*/


                                $permnew = "Kreátor";
                                $permnewlen = strlen($permnew);
                                $permcreatenewlen = '"'.$_SESSION["user"]["felhasznalonev"].'";s:10:"permission";s:'.$permnewlen.':"'.$permnew.'";';
                                

                                $strr=file_get_contents('users.txt');
                                $strr=str_replace("$permcreateoldlen", "$permcreatenewlen",$strr);
                                file_put_contents('users.txt', $strr);

                                echo"<script>alert('Sikeres Kreátor jog hozzáadva a fiókhoz, újra be kell lépned!')</script>";
                                echo"<script>window.location.href = 'logout.php';</script>";
                                break;
                                }
                        }
                    }
                ?>
                <form action="explore.php" method="POST">
                    <input type="submit" name="give_perm" id="give_perm" value="Kreátor szeretnék lenni!" class="btn-hoverfinal2">
                </form>
            </div>
            <?php }
             }?>
        </div>
        <br>

        <?php
            $files = glob("img/explore/*.*");
            include "filemegnyit.php";
            $osszeskep = loadPhoto("kepek.txt");

            echo"<div class='gallery' id='gallery'>";
            if(isset($_POST['autok'])) {
                
                foreach ($osszeskep as $img) {
                    if($img["tema"] === "autok"){
                        echo'<div class="gallery-item">';
                        echo'<div class="content"><img src='.$img["kepnev"].' alt=""></div>';
                        echo'</div>';
                    }
                }
            }
            if(isset($_POST['tajkep'])) {
                
                foreach ($osszeskep as $img) {
                    if($img["tema"] === "tajkep"){
                        echo'<div class="gallery-item">';
                        echo'<div class="content"><img src='.$img["kepnev"].' alt=""></div>';
                        echo'</div>';
                    }
                }
            }
            if(isset($_POST['cica'])) {
               
                foreach ($osszeskep as $img) {
                    if($img["tema"] === "cica"){
                        echo'<div class="gallery-item">';
                        echo'<div class="content"><img src='.$img["kepnev"].' alt=""></div>';
                        echo'</div>';
                    }
                }
            }
            if(isset($_POST['etel'])) {
                
                foreach ($osszeskep as $img) {
                    if($img["tema"] === "etel"){
                        echo'<div class="gallery-item">';
                        echo'<div class="content"><img src='.$img["kepnev"].' alt=""></div>';
                        echo'</div>';
                    }
                }
            }
            if(isset($_POST['divat'])) {
                
                foreach ($osszeskep as $img) {
                    if($img["tema"] === "divat"){
                        echo'<div class="gallery-item">';
                        echo'<div class="content"><img src='.$img["kepnev"].' alt=""></div>';
                        echo'</div>';
                    }
                }
            }
            if(isset($_POST['osszes'])) {
                
                foreach ($osszeskep as $img) {
                        echo'<div class="gallery-item">';
                        echo'<div class="content"><img src='.$img["kepnev"].' alt=""></div>';
                        echo'</div>';
                }
            }
            if(!isset($_POST['osszes']) && !isset($_POST['autok']) && !isset($_POST['tajkep']) && !isset($_POST['cica']) && !isset($_POST['etel']) && !isset($_POST['divat'])){
                
                foreach ($osszeskep as $img) {
                    echo'<div class="gallery-item">';
                    echo'<div class="content"><img src='.$img["kepnev"].' alt=""></div>';
                    echo'</div>';
                }
            }
            echo"</div>";
        ?>
        
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