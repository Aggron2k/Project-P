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
    <title>Project P - Activity</title>
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
                <li><a href="profil.php">Profil</a></li>
                <li><a href="chat.php">Üzenetek</a></li>
                <li><a href="activity.php" class="active">Tevékenység</a></li>
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
            <div class="form-box-act">
                    <div>
                    <h3 style="margin-left: 25px">Eddigi kép felöltéseid!</h3>
                        <div class="form-box3">
                            <?php
                                include "filemegnyit.php";
                                $osszeskep = loadPhoto("kepek.txt");
                                echo"<div class='gallery' id='gallery'>";
                                foreach ($osszeskep as $img) {
                                    if($img["felhasznalonev"] === $_SESSION["user"]["felhasznalonev"]){
                                        echo'<div class="gallery-item">';
                                        echo'<div class="content"><img src='.$img["kepnev"].' alt=""></div>';
                                        echo'</div>';
                                    }
                                }
                                echo"</div>";
                            ?>
                        </div>
                    </div>

                    <div class="input-group5">
                        <h3 style="margin-left: 25px; margin-bottom: 25px;">Szöveges formában!</h3>
                        <div class="form-box3">
                        <table>
                            <tr>
                                <th>Felhasználónév</th>
                                <th>Téma</th>
                                <th>Képnév</th>
                                <th>Feltöltési dátum</th>
                            </tr>
                            <?php
                                foreach ($osszeskep as $img) {
                                        if($img["felhasznalonev"] === $_SESSION["user"]["felhasznalonev"]){
                                            echo"<tr>";
                                                echo"<td>".$img["felhasznalonev"]."</td>";
                                                echo"<td>".$img["tema"]."</td>";
                                                echo"<td>".$img["kepnev"]."</td>";
                                                echo"<td>".$img["datum"]."</td>";
                                            echo"</tr>";
                                        }
                                    }
                            ?>
                        </table>
                        </div>
                    </div>
                
            </div>
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