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
   <!-- creators -->
   <title>Project P - Creators</title>
</head>

<body>
<header>
        
        <a href="index.php"><img src="img/logot.png" alt="Project P logo" class="menu-logo"></a>
        <?php if (isset($_SESSION["user"])) { ?>
        <nav>
            <ul class="nav_links">
                <li><a href="index.php">Home</a></li>
                <li><a href="explore.php">Fedezd Fel!</a></li>
                <li><a href="creators.php" class="active">Kreátorok</a></li>
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
                <li><a href="explore.php">Fedezd Fel!</a></li>
                <li><a href="creators.php" class="active">Kreátorok</a></li>
            </ul>
        </nav>
        <form style="display: inline" action="signlogin.php" method="get">
            <button class="btn-hoverfinal">Bejelentkezés Regisztráció</button>
        </form>
        <?php } ?>

    </header>

   <main>
      <div id="showcase" class="grid">
         <div class="bg-image_fou"></div>
         <div class="content-wrap">
            <h1>A <em>Kreátorok</em> a mi büszkeségeink.</h1>
            <hr>
            <p>Itt érhetőek el a legjobb kreátoraink akik arról gondoskodnak hogy a legszebb minőségű képeket hozzák el
               nekünk.</p>
         </div>
      </div>

      <?php
            echo"<div class='creators-card'>";
            foreach($fiokok as $fiok)
            {
                     $utvonal = "img/profilpictures/" . $fiok["felhasznalonev"];
                     $kiterjesztesek = ["png", "jpg", "jpeg"];
                     $profilkep = "img/profilpictures/default.jpg";
                     foreach ($kiterjesztesek as $kiterjesztes) {
                     if (file_exists($utvonal . "." . $kiterjesztes)) {
                        $profilkep = $utvonal . "." . $kiterjesztes;
                        }
                     
                     }
                     
                     echo"<div class='card-container'>";
                        echo"<div class='upper-container' style='background: ".$fiok["szin"]."'>";
                           echo"<div class='image-container'>";
                              echo"<img src='$profilkep' alt='Profilkép'/>";
                           echo"</div>";
                        echo"</div>";
                      echo"<div class='lower-container'>";
                  echo"<div>";
                     echo"<h3>".$fiok["fullname"]."</h3>";
                     echo"<h5 >@".$fiok["felhasznalonev"]."</h5>";
                     echo"<h4>".$fiok["permission"]."</h4>";
                  echo"</div>";
                  echo"<div>";
                     echo"<p>".$fiok["desc"]."</p>";
                  echo"</div>";
                  echo"</div>";
                  echo"</div>";
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