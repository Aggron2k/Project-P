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
    <title>Project P - Chat</title>
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
                <li><a href="chat.php" class="active">Üzenetek</a></li>
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
            <div class="form-box-mes">

                <h3 style="margin-left: 25px">Kapott üzenetek!</h3>
                <form action="chat.php" method="GET">
                    <div class="form-box2">
                        
                        <?php
                            include "filemegnyit.php";
                            $osszesuzenetforditott = loadMessages("uzenetek.txt");
                            $osszesuzenetforditott = array_reverse($osszesuzenetforditott);

                            foreach($osszesuzenetforditott as $uzenet)
                            {
                                if($uzenet["cimzett"] === $_SESSION["user"]["felhasznalonev"]){
                                        $utvonal = "img/profilpictures/" . $uzenet["felado"];
                                        $kiterjesztesek = ["png", "jpg", "jpeg"];

                                        foreach ($kiterjesztesek as $kiterjesztes) {
                                        if (file_exists($utvonal . "." . $kiterjesztes)) {
                                            $profilkep = $utvonal . "." . $kiterjesztes;
                                            }
                                        }
                                        echo"<div class='massage'>";
                                        echo"<div class='massage-top' style='background: ".$uzenet["feladoszin"].";'>";
                                            echo"<img src='$profilkep' alt='Profilkép' class='profpic-mes' />";
                                            echo"<h3>".$uzenet["felado"]."</h3>";
                                            echo"<p>".$uzenet["datum"]."</p>";
                                        echo"</div>";
                                        echo"<div class='massage-bottom'>";
                                        echo"<p>".$uzenet["uzenet"]."</p>";
                                        echo"</div>";
                                        echo'</div>';
                                }
                            }
                        ?>
                    </div>
                </form>

                <h3 style="margin-left: 25px">Küldött üzenetek!</h3>
                <form action="chat.php" method="GET">
                    <div class="form-box2">
                    <?php
                            $osszesuzenetforditott = loadMessages("uzenetek.txt");
                            $osszesuzenetforditott = array_reverse($osszesuzenetforditott);
                            foreach($osszesuzenetforditott as $uzenet)
                            {
                                if($uzenet["felado"] === $_SESSION["user"]["felhasznalonev"]){
                                        $utvonal = "img/profilpictures/" . $uzenet["felado"];
                                        $kiterjesztesek = ["png", "jpg", "jpeg"];
                                        $profilkep = "img/profilpictures/default.jpg";
                                        foreach ($kiterjesztesek as $kiterjesztes) {
                                        if (file_exists($utvonal . "." . $kiterjesztes)) {
                                            $profilkep = $utvonal . "." . $kiterjesztes;
                        }
                     
                     }

                                        foreach ($kiterjesztesek as $kiterjesztes) {
                                        if (file_exists($utvonal . "." . $kiterjesztes)) {
                                            $profilkep = $utvonal . "." . $kiterjesztes;
                                            }
                                        }
                                        echo"<div class='massage'>";
                                        echo"<div class='massage-top' style='background: ".$uzenet["feladoszin"].";'>";
                                            echo"<img src='$profilkep' alt='Profilkép' class='profpic-mes' />";
                                            echo"<h3>".$uzenet["felado"]." => ".$uzenet["cimzett"]."</h3>";
                                            echo"<p>".$uzenet["datum"]."</p>";
                                        echo"</div>";
                                        echo"<div>";
                                        echo"<p>".$uzenet["uzenet"]."</p>";
                                        echo"</div>";
                                        echo'</div>';
                                }
                            }
                        ?>
                    </div>
                </form>
                <br>

                
                <?php
                if (isset($_POST["submit_send"])) {
                    $hibak = 0;
                    if (!isset($_POST["cimzett"]) || trim($_POST["cimzett"]) === "") {
                        echo"<script>alert('Nincs kíválasztva a címzett!')</script>";
                        $hibak = 1;
                    }
                    if (!isset($_POST["uzenet"]) || trim($_POST["uzenet"]) === "") {
                        echo"<script>alert('Üzenet rész üres, írj üzenetet!')</script>";
                        $hibak = 1;
                    }
                        $felado = $_SESSION["user"]["felhasznalonev"];
                        $feladoszin = $_SESSION["user"]["szin"];
                        $cimzett = $_POST["cimzett"];
                        $uzenet = $_POST["uzenet"];
                        $datum = date("Y.m.d");

                    if ($hibak === 0) {
                        $uzenetek[] = ["felado" => $felado, "feladoszin" => $feladoszin, "cimzett" => $cimzett, "uzenet" => $uzenet, "datum" => $datum];
                        $file = fopen("uzenetek.txt", "a");
                        if ($file === FALSE)
                            die("HIBA: A fájl megnyitása nem sikerült!");
                    
                        foreach($uzenetek as $uzenet) {
                            $serialized_mes = serialize($uzenet);
                            fwrite($file, $serialized_mes . "\n");
                        }
                        fclose($file);
                        $siker = TRUE;
                        if (isset($siker) && $siker === TRUE) {
                            echo"<script>alert('Üzenet elküldve!')</script>";
                            echo"<script>window.location.href = 'chat.php';</script>";
                        }
                    } else {
                        $siker = FALSE;
                    }
                }
                
            ?>
                <form action="chat.php" method="POST" id="send" class="input-group4">
                    <h3>Üzenet küldés</h3>
                    <input type="text" class="input-field" placeholder="Címzett" disabled>
                    <select name="cimzett" style="width: 100%" required multiple>
                    <?php
                            foreach ($fiokok as $user) {
                                echo'<option value="'.$user["felhasznalonev"].'">'.$user["felhasznalonev"].'</option>';
                            }
                    ?>
                    </select>
                    <input type="text" class="input-field" name="uzenet" style="width: 100%;" placeholder="Üzenet">
                    <input type="submit" name="submit_send" id="submit_send" class="btn-hoverfinal" value="Üzenet küldése!"/>
                </form>
                
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