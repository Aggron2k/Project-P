<?php
  session_start();
  include "logsighelp.php";

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
    <!-- fooldal -->
    <title>Project P - Home</title>
</head>

<body>
    <header>

        <a href="index.php"><img src="img/logot.png" alt="Project P logo" class="menu-logo"></a>
        <?php if (isset($_SESSION["user"])) { ?>

        <nav>
            <ul class="nav_links">
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="explore.php">Fedezd Fel!</a></li>
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
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="explore.php">Fedezd Fel!</a></li>
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
            <div class="bg-image"></div>
            <div class="content-wrap">
                <?php
                    $latogatasok = 1;

                    if (isset($_COOKIE["visits"])) {
                    $latogatasok = $_COOKIE["visits"] + 1;
                    }

                    setcookie("visits", $latogatasok, time() + (60*60*24*30), "/");

                    if ($latogatasok > 1 && $latogatasok < 51) {
                        echo "<h1>Üdv a <em>Project P</em>-nél!</h1>";
                        echo "Üdvözöllek ismét! Ez a(z) $latogatasok. látogatásod.";
                    }
                    elseif($latogatasok > 50){
                        echo "<h1>Üdv a <em>Project P</em>-nél!</h1>";
                        echo "Üdvözöllek ismét veterán! Ez a(z) $latogatasok. látogatásod.";
                    }
                    else {
                        echo "<h1>Üdv a <em>Project P</em>-nél!</h1>";
                        echo "Új vagy még semmi baj, érezd magad otthon!";
                      }
                ?>
                <hr>
                <p>Fedezd fel a rengeteg képet, amelyeket nagylelkű kreátoraink osztott meg sok-sok tematikában!</p>
            </div>
        </div>
        <br>
        <div class="slider">
            <div class="slides">
                <input type="radio" name="radio-btn" id="radio1">
                <input type="radio" name="radio-btn" id="radio2">
                <input type="radio" name="radio-btn" id="radio3">
                <input type="radio" name="radio-btn" id="radio4">

                <div class="slide first">
                    <img src="img/slides/slides1.jpg" alt="">
                </div>
                <div class="slide">
                    <img src="img/slides/slides2.jpg" alt="">
                </div>
                <div class="slide">
                    <img src="img/slides/slides3.jpg" alt="">
                </div>
                <div class="slide">
                    <img src="img/slides/slides4.jpg" alt="">
                </div>
                <div>
                    <div class="auto-btn1"></div>
                    <div class="auto-btn2"></div>
                    <div class="auto-btn3"></div>
                    <div class="auto-btn4"></div>
                </div>
            </div>
            <div class="navigation-manual">
                <label for="radio1" class="manual-btn"></label>
                <label for="radio2" class="manual-btn"></label>
                <label for="radio3" class="manual-btn"></label>
                <label for="radio4" class="manual-btn"></label>
            </div>
        </div>
        <div id="showcase_under" class="grid">
            <div class="bg-image_sec"></div>
            <div class="content-wrap">
                <h1>Lehetőségek tárháza csak rád vár!</h1>
                <p>Különböző <strong>témák</strong>-ra könnyedén tudsz szűrni egy szimpla kattintásal.</p>
                <p>Témákat a <strong>Fedezd fel!</strong> fülön érheted el.</p>
                <div class="card_box">
                    <div class="card">
                        <img src="img/cards/autok_card.png" alt="Avatar" style="width:100%">
                        <div class="container">
                            <h4><b>Autok</b></h4>
                        </div>
                    </div>

                    <div class="card">
                        <img src="img/cards/tajkep_card.png" alt="Avatar" style="width:100%">
                        <div class="container">
                            <h4><b>Tájkép</b></h4>
                        </div>
                    </div>

                    <div class="card">
                        <img src="img/cards/cica_card.png" alt="Avatar" style="width:100%">
                        <div class="container">
                            <h4><b>Cica</b></h4>
                        </div>
                    </div>

                    <div class="card">
                        <img src="img/cards/etel_card.png" alt="Avatar" style="width:100%">
                        <div class="container">
                            <h4><b>Étel</b></h4>
                        </div>
                    </div>

                    <div class="card">
                        <img src="img/cards/divat_card.png" alt="Avatar" style="width:100%">
                        <div class="container">
                            <h4><b>Divat</b></h4>
                        </div>
                    </div>
                </div>
            </div>
            <h1>Hogy mik is azok a <em>Képek</em>?</h1>
            <hr>
            <video src="video/Images.mp4" controls width="720">A video betöltése során hiba történt! :(</video>
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