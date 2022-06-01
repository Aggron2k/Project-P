<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
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
    <link rel="stylesheet" href="css/sign-style.css">
    <!-- regisztrációs, és bejelentkezés oldala -->
    <title>Project P - Log In</title>
</head>

<body>
    <img src="img/logot.png" alt="Logo" class="logo">
    <div class="hero">
        <div class="form-box">
            <div class="button-box">
                <div class="btn">
                    <button type="button" class="btn-hoverfinal" onclick="login()">Bejelentkezés</button>
                    <button type="button" class="btn-hoverfinal" onclick="register()">Regisztráció</button>
                </div>
            </div>
            <?php
                session_start();
                include "logsighelp.php";
                $fiokok = loadUsers("users.txt");

                if (isset($_POST["login"])) {
                    if (!isset($_POST["felhasznalonev"]) || trim($_POST["felhasznalonev"]) === "" || !isset($_POST["jelszo"]) || trim($_POST["jelszo"]) === "") {
                    echo"<script>alert('Adj meg minden adatot!')</script>";
                    } else {
                    $felhasznalonev = $_POST["felhasznalonev"];
                    $jelszo = $_POST["jelszo"];

                    foreach ($fiokok as $fiok) {
                        if ($fiok["felhasznalonev"] === $felhasznalonev && password_verify($jelszo, $fiok["jelszo"])) {
                        $_SESSION["user"] = $fiok;
                        header("Location: index.php");
                        break;
                        }
                    }

                    echo"<script>alert('Sikertelen belépés! A belépési adatok nem megfelelők!')</script>";
                    }
                }
            ?>
            <section>
                <form action="signlogin.php" method="POST" id="login" class="input-group">
                    <input type="text" name="felhasznalonev" class="input-field" placeholder="Felhasználó név" required>
                    <input type="password" name="jelszo" class="input-field" placeholder="Jelszó" required>
                    <input type="submit" name="login" id="submit-btn_log" class="btn-hoverfinal" value="Bejelentkezés">
                    <button onclick="location.href='index.php'" class="btn-hoverfinal" type="button">Tovább a weboldalra</button>
                </form>
            </section>
            <!-- REGISZTRACIO -->
            <?php

                $hibak = 0;
                if (isset($_POST["regiszt"])) { 
                    if (!isset($_POST["fullname"]) || trim($_POST["fullname"]) === "") {
                        echo"<script>alert('Teljes nevedet is add meg!')</script>";
                        $hibak = 1;
                    }

                    if (!isset($_POST["felhasznalonev"]) || trim($_POST["felhasznalonev"]) === "") {
                        echo"<script>alert('Felhasználónév kötelező!')</script>";
                        $hibak = 1;
                    }
                    
                    if (!isset($_POST["jelszo"]) || trim($_POST["jelszo"]) === "" || !isset($_POST["jelszo2"]) || trim($_POST["jelszo2"]) === "") {
                        echo"<script>alert('Mindkét jelszó szükséges!')</script>";
                        $hibak = 1;
                    }
                    

                    if (!isset($_POST["nem"]) || trim($_POST["nem"]) === "") {
                        echo"<script>alert('Szükséges a nemed is!')</script>";
                        $hibak = 1;
                    }

                    if (!isset($_POST["szin"]) || trim($_POST["szin"]) === "") {
                        echo"<script>alert('Nem adtad meg a kedvenc színedet!')</script>";
                        $hibak = 1;
                    }

                    if (!isset($_POST["desc"]) || trim($_POST["desc"]) === "") {
                        echo"<script>alert('Írj magadról valamit, ne hagyd ki azt a részt!')</script>";
                        $hibak = 1;
                    }

                    $fullname = $_POST["fullname"];
                    $felhasznalonev = $_POST["felhasznalonev"];
                    $permission = "Felhasználó";
                    $jelszo = $_POST["jelszo"];
                    $jelszo2 = $_POST["jelszo2"];
                    $nem = NULL;
                    $szin = $_POST["szin"];
                    $desc = $_POST["desc"];

                    if (isset($_POST["nem"]))
                    $nem = $_POST["nem"];

                    foreach ($fiokok as $fiok) {
                    if ($fiok["felhasznalonev"] === $felhasznalonev) {
                        echo"<script>alert('Felhasználó már regisztrált!')</script>";
                        $hibak = 1;
                        }

                        if ($fiok["szin"] === $szin) {
                            echo"<script>alert('Egy felhasználónak már van ilyen színe, válassz másikat!')</script>";
                            $hibak = 1;
                        }
                    }

                    if (strlen($jelszo) < 6) {
                        echo"<script>alert('6 karakter hosszú jelszó szükséges!')</script>";  
                        $hibak = 1;
                    }

                    if ($jelszo !== $jelszo2) {
                        echo"<script>alert('Nem egyezik a két jelszó!')</script>";
                        $hibak = 1;
                    }

                    uploadProfilePicture($felhasznalonev);

                              
                    $jelszo = password_hash($jelszo, PASSWORD_DEFAULT);
                    $fiokok[] = ["fullname" => $fullname, "felhasznalonev" => $felhasznalonev, "permission" => $permission, "jelszo" => $jelszo, "nem" => $nem, "szin" => $szin, "desc" => $desc];
                    saveUsers("users.txt", $fiokok);
                    $siker = TRUE;
                    if (isset($siker) && $siker === TRUE) {
                            echo"<script>alert('Sikeres regisztráció!')</script>";
                            echo"<script>window.location.href = 'signlogin.php';</script>";
                        }
                    } else {
                    $siker = FALSE;
                    }
                
                ?>
            <section>
            <form action="signlogin.php" method="POST" enctype="multipart/form-data" id="register" class="input-group">
                <input type="text" class="input-field" name="fullname" placeholder="Teljes név" required>
                <input type="text" class="input-field" name="felhasznalonev" placeholder="Felhasználó név" required>
                <input type="password" class="input-field" name="jelszo" placeholder="Jelszó (min 6 karakter)" required>
                <input type="password" class="input-field" name="jelszo2" placeholder="Jelszó újra (min 6 karakter)" required>
                <input type="text" class="input-field" placeholder="Nem" disabled>
                <input type="radio" id="ferfi" name="nem" value="Férfi" <?php if (isset($_POST['nem']) && $_POST['nem'] === 'Férfi') echo 'checked'; ?>>
                <label for="ferfi">Férfi</label>
                <input type="radio" id="no" name="nem" value="Nő" <?php if (isset($_POST['nem']) && $_POST['nem'] === 'Nő') echo 'checked'; ?>>
                <label for="no">Nő</label>
                <input type="text" class="input-field" placeholder="Kedvenc színed" disabled>
                <input type="color" name="szin">
                <input type="text" class="input-field" placeholder="Profilkép" disabled>
                <input type="file" name="profile-pic" accept="image/*"/>
                <input type="text" class="input-field" name="desc" placeholder="Írj magadról vagy valami gondolatot." required>

                <input type="submit" name="regiszt" id="submit-btn_reg" class="btn-hoverfinal" value="Regisztráció">
            </form>
            </section>
        </div>
    </div>
    <script src="script/script.js"></script>
</body>

</html>