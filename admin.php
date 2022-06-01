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
    if($_SESSION["user"]["permission"] == 'Kreátor' || $_SESSION["user"]["permission"] == 'Felhasználó' ){
        header("Location: index.php");
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
                <li><a href="activity.php">Tevékenység</a></li>
            </ul>
        </nav>
        <form style="display: inline" action="logout.php" method="get">
            <button class="btn-hoverfinal2">Kijelentkezés</button>
        </form>
        <img src="<?php echo $profilkep; ?>" alt="Profilkép" class="profpic" />
            <?php if($_SESSION["user"]["permission"] == 'Admin'){ ?>
                <p><a href="admin.php" class="active_admin">Admin felület</a></p>
            <?php } else{?>
            <p><a href="profil.php"><?php echo $_SESSION["user"]["felhasznalonev"]; ?></a></p>
            <?php } ?>
        <?php } ?>

    </header>

    <main>
    <div class="hero">
            <div class="form-box">
                    <div>
                    <h3 style="margin-left: 25px">Felhasználók</h3>
                        <div class="form-box3">
                            <?php
                                include "filemegnyit.php";
                                $felhasznalok = loadPhoto("users.txt");
                                
                            ?>
                            <table>
                            <tr>
                                <th>Teljes név</th>
                                <th>Felhasználó név</th>
                                <th>Jogosultság</th>
                                <th>Nem</th>
                                <th>Kedvenc szín</th>
                                <th>Leírás</th>
                            </tr>
                            <?php
                                foreach ($felhasznalok as $user) {
                                        
                                            echo"<tr>";
                                                echo"<td>".$user["fullname"]."</td>";
                                                echo"<td>".$user["felhasznalonev"]."</td>";
                                                echo"<td>".$user["permission"]."</td>";
                                                echo"<td>".$user["nem"]."</td>";
                                                echo"<td>".$user["szin"]."</td>";
                                                echo"<td>".$user["desc"]."</td>";
                                            echo"</tr>";
                                        
                                    }
                            ?>
                        </table>
                        </div>
                    </div>
                    <?php
                        if (isset($_POST["submit_ban"])) {

                            foreach ($fiokok as $fiok) {

                                $banfelhasznalo = $_POST["felhasznalo"];
                                if ($fiok["felhasznalonev"] === $banfelhasznalo ) {
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


                                    echo"<script>alert('Sikeres bannolás, F5 hogy újra töltse a felhasználókat!')</script>";
                                    break;
                                    }
                            }
                        }

                    ?>
                    <form action="admin.php" method="POST" id="ban" class="input-group3">
                    <h3>Ki legyen kibannolva?</h3>
                    <input type="text" class="input-field" placeholder="Felhasználók" disabled>
                    <select name="felhasznalo" style="width: 100%" required multiple>
                    <?php
                            foreach ($fiokok as $user) {
                                echo'<option value="'.$user["felhasznalonev"].'">'.$user["felhasznalonev"].'</option>';
                            }
                    ?>
                    </select>
                    <input type="submit" name="submit_ban" id="submit_ban" class="btn-hoverfinalred" value="BAN!"/>
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