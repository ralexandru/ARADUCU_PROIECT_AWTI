<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "db_functions.php";
    $nume = $_POST["numeUtilizator"];
    if (verificaUtilizator($nume)) {
        $parola = $_POST["parola"];
        $dataNasterii = $_POST["dataNastere"];
        $tara = $_POST["tara"];
        $adresaMail = $_POST["adresaMail"];
        $siteWeb = $_POST["siteWeb"];
        $nrTelefon = $_POST["nrTelefon"];

        // Se adauga un nou utilizator
        registerUtilizator(
            $nume,
            $parola,
            $dataNasterii,
            $tara,
            $adresaMail,
            $siteWeb,
            $nrTelefon
        );
    } else {
        header("Location: register.php?registerFailed=true");
    }
}
if (isset($_GET["logout"]) && $_GET["logout"] == "true") {
    echo "<script>";
    echo 'localStorage.removeItem("logat");';
    echo "</script>";
}
?>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles/register.css">
        <link rel="stylesheet" href="styles/navbar.css">
        <link rel="icon" href="imgs/logo.svg" type="image/svg+xml">
        <title>Login</title>
    </head>
    <body>
    <div id="navbar">
            <a href="#" class="logo" width="100%" height="100%">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" width="100%" height="100%" style="background-color: black;">
                <rect width="100%" height="100%" fill="black" stroke="white" stroke-width="1"/>
            
                <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="Arial" font-size="16">StreamMusic</text>
            </svg>
            </a>
            <a href="home.php" class="menuItem" width="100%" height="100%">Home</a>
            <?php
            echo "<script>";
            echo 'var isLoggedIn = localStorage.getItem("logat") === "true";';
            echo 'var nivelAcces = localStorage.getItem("nivelAcces");';

            echo "if (!isLoggedIn) {";
            echo '    document.write(\'<a href="register.php" class="menuItem" width="100%" height="100%">Inregistrare</a>\');';
            echo '    document.write(\'<a href="login.php" class="menuItem" width="100%" height="100%">Login</a>\');';
            echo "}";
            echo "else{";
            echo '    document.write(\'<a href="login.php?logout=true" class="menuItem" width="100%" height="100%">Logout</a>\');';
            echo '    document.write(\'<a href="playlists.php" class="menuItem" width="100%" height="100%">Adauga playlist</a>\');';
            echo "    if (nivelAcces==1)";
            echo '      document.write(\'<a href="addSong.php" class="menuItem" width="100%" height="100%">Administrare</a>\');';
            echo "}";
            echo "</script>";
            ?>           
            <a href="aboutUs.php" class="menuItem" width="100%" height="100%">Despre noi</a>
            <div id="coords" style="margin: 0px; display: flex; align-items: center; padding: 0px;">
            <img src="https://cdn-icons-png.flaticon.com/512/6121/6121287.png" style="width: 30px; height: 30px; margin-right: 5px;">
            <div style="display: flex; flex-direction: column;">
                <p id="x-coord" style="color: white; margin-bottom: 0px; margin-top: 0px;"></p>
                <p id="y-coord" style="color: white; margin-bottom: 0px; margin-top: 0px;"></p>
            </div>
        </div>
    </div>
        <div id="register-container" style="width:100%;">
            <form id="register-form" action="home.php" method="post">
            <center>
                <?php if (
                    isset($_GET["loginFailed"]) &&
                    $_GET["loginFailed"] == "true"
                ) {
                    echo "<span style='color:red;font-size:20px'>Login failed. Please try again.</span>";
                } ?>
                <h1 style="font-family: 'Your Desired Font', sans-serif;">Login</h1>
                <hr style="border:1px solid black; width: 50%"/><br/>
                <div>
                    <span style="display: block; text-align: center;">Nume Utilizator: </span>
                    <input type="text" name="numeUtilizator" style="width:80%; height: 30px" pattern="[A-Za-z]+" title="Va rugam introduceti un nume de utilizator valid fara spatii si spatii" required>
                </div><br/>
                <div>
                <span style="display: block; text-align: center;">Parola: </span>
                    <input type="password" name="parola" style="width:80%; height: 30px" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$" 
                title="Va rugam introduceti o parola de cel putin 8 caractere, care sa contina o litera mare, o litera mica si o cifra" 
                required>
                </div><br/>
                <input type="image" src="imgs/button_login.png" alt="Submit"> 
                
            </center>
            </form>
        </div>
    </body>
    <script src="js/locatie.js"></script>
    <script>
        // Creaza un nou Web Worker
        const worker = new Worker('ww/timeWebWorker.js');

        // Asculta mesajele din partea acestuia
        worker.addEventListener('message', function(event) {
            // Actualizeaza interfata cu timpul primit de la acesta
            document.getElementById('ceas').textContent = event.data;
        });
    </script>