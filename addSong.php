<?php

include "db_manager.php";

if (isset($_GET["logout"]) && $_GET["logout"] == "true") {
    echo "<script>";
    echo 'localStorage.removeItem("logat");';
    echo "</script>";
}
$databaseManager = new DatabaseManager("localhost", "root", "", "proiect_awti");

$melodii = $databaseManager->getAllMelodii();
$artisti = $databaseManager->getAllArtisti();
$genuriMuzicale = $databaseManager->getAllGenuriMuzicale();
?>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles/navbar.css">
        <link rel="stylesheet" href="styles/hideDetails.css">

        <link rel="icon" href="imgs/logo.svg" type="image/svg+xml">
        <title>Administrare</title>
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
                <div style="display: flex; flex-direction: column;margin-right:10px">
                    <p id="x-coord" style="color: white; margin-bottom: 0px; margin-top: 0px;"></p>
                    <p id="y-coord" style="color: white; margin-bottom: 0px; margin-top: 0px;"></p>
                </div>
            <div id="coords" style="margin: 0px; display: flex; align-items: center; padding: 0px;">
                <img src="https://cdn-icons-png.flaticon.com/512/8764/8764297.png" style="width: 30px; height: 30px; ">
                    <p id="ceas" style="color: white; margin-bottom: 0px; margin-top: 0px;">test</p>

            </div>
        </div>
        </div>
     <h1 style="font-family: 'Your Desired Font', sans-serif;text-align:center;">Administrare (Adaugare)</h1>
     <hr style="border:1px solid black; width: 50%"/><br/>
     <center>
     <details style="margin-top:1%;width:90%;text-align:center">
        <summary style="font-size:40px"> Adauga melodie </summary>
        <center><div id="2register-container" style="width:100%;padding-top:3%;padding-bottom:3%;background-color:white;">
            <form id="register-form" action="restAPIs/playlistController.php" style="text-align:center" method="post">
                <?php if (
                    isset($_GET["loginFailed"]) &&
                    $_GET["loginFailed"] == "true"
                ) {
                    echo "<span style='color:red;font-size:20px'>Login failed. Please try again.</span>";
                } ?>
                <div>
                    <span style="display: block; text-align: center;">Nume melodie: </span>
                    <input type="text" name="denumireMelodie" style="width:80%; height: 30px" pattern="[A-Za-z]+" title="Va rugam introduceti un nume de utilizator valid fara spatii si spatii" required>
                </div><br/>
                <div>
                <span style="display: block; text-align: center;">Artist: </span>
                    <select name="artist" style="width:80%; height: 30px">
                        <?php foreach ($artisti as $artist) {
                            echo "<option value=" .
                                $artist->ArtistId .
                                ">" .
                                $artist->GetNumePrenume() .
                                "</option>";
                        } ?>
                    </select>
                </div><br/>
                <div>
                <span style="display: block; text-align: center;">Gen muzical: </span>
                    <select name="genMuzical" style="width:80%; height: 30px">
                        <?php foreach ($genuriMuzicale as $genMuzical) {
                            echo "<option value=" .
                                $genMuzical->GenMuzicalId .
                                ">" .
                                $genMuzical->Denumire .
                                "</option>";
                        } ?>
                    </select>
                </div><br/>
                <div>
                    <span style="display: block; text-align: center;">Video: </span>
                    <input type="file" id="fisierVideo" name="video" style="width:80%; height: 30px"  title="Va rugam introduceti un nume de utilizator valid fara spatii si spatii" required>
                    <br/>
                    <input type="text" id="textVideo" name="videoText" style="width:80%; height: 30px" title="Va rugam introduceti un nume de utilizator valid fara spatii si spatii" required>

                </div><br/>
                    <div>
                        <span style="display: block; text-align: center;">Versuri: </span>
                        <input type="file" id="fisierVersuri" name="versuri" style="width:80%; height: 30px" title="Va rugam introduceti un nume de utilizator valid fara spatii si spatii" required>
                        <input type="text" id="textVersuri" name="versuriText" style="width:80%; height: 30px" title="Va rugam introduceti un nume de utilizator valid fara spatii si spatii" required>
                    </div><br/>
                <div>
                    <span style="display: block; text-align: center;">Thumbnail: </span>
                    <input type="file" id="fisierThumbnail" name="thumbnail" style="width:80%; height: 30px" pattern="" title="Va rugam introduceti un nume de utilizator valid fara spatii si spatii" required>
                    <input type="text" id="textThumbnail" name="thumbnailText" style="width:80%; height: 30px" title="Va rugam introduceti un nume de utilizator valid fara spatii si spatii" required>
                </div><br/>
                <div>
                    <span style="display: block; text-align: center;">Descriere: </span>
                    <textarea name="descriere" style="width:80%; height: 200px" title="Va rugam introduceti un nume de utilizator valid fara spatii si spatii" required> </textarea>
                </div><br/>
                <input type="hidden" name="adaugaMelodie" value="true"/>
                <div>
                    <input type="image" src="imgs/button_adauga-melodie.png" alt="Submit"> 
                </div>
            </form>
        </div></center>
       </details>
    
    <details style="margin-top:1%;width:90%;text-align:center;">
        <summary style="font-size:40px;background-color:green"> Adauga artist </summary>    
        <center><div style="width:100%;float:center;padding-top:3%;padding-bottom:3%;background-color:white;background-color:white;">
                <form id="register-form" action="restAPIs/playlistController.php" style="" method="post">
                    <?php if (
                        isset($_GET["loginFailed"]) &&
                        $_GET["loginFailed"] == "true"
                    ) {
                        echo "<span style='color:red;font-size:20px'>Login failed. Please try again.</span>";
                    } ?>
                    <div>
                        <span style="display: block; text-align: center;">Nume artist: </span>
                        <input type="text" name="numeArtist" style="width:80%; height: 30px" pattern="[A-Za-z]+" title="Va rugam introduceti numele artistului pe care doriti sa il adaugati" required>
                    </div><br/>
                    <div>
                        <span style="display: block; text-align: center;">Prenume artist: </span>
                        <input type="text" name="prenumeArtist" style="width:80%; height: 30px" pattern="[A-Za-z]+" title="Va rugam introduceti prenumele artistului pe care doriti sa il adaugati" required>
                    </div><br/>
                    <input type="hidden" name="adaugaArtist" value="true"/>
                    <div>
                        <input type="image" src="imgs/button_adauga-artist.png" alt="Submit"> 
                    </div>
                </form>
            </div>
        </center>
    </details>
    <details style="margin-top:1%;width:90%;text-align:center">
        <summary style="font-size:40px;background-color:lime"> Adauga gen muzical </summary>
        <center><div style="width:100%;padding-top:3%;padding-bottom:3%;background-color:white;">
                    <form id="register-form" action="restAPIs/playlistController.php" method="post">
                        <?php if (
                            isset($_GET["loginFailed"]) &&
                            $_GET["loginFailed"] == "true"
                        ) {
                            echo "<span style='color:red;font-size:20px'>Login failed. Please try again.</span>";
                        } ?>
                        <div>
                            <span style="display: block; text-align: center;">Nume gen muzical: </span>
                            <input type="text" name="denumireGenMuzical" style="width:80%; height: 30px" pattern="[A-Za-z]+" title="Va rugam introduceti numele artistului pe care doriti sa il adaugati" required>
                        </div><br/>
                        <div>
                            <span style="display: block;">Descriere: </span>
                            <textarea name="descriereGenMuzical" style="width:80%; height: 10s0px" pattern="[A-Za-z]+" title="Va rugam introduceti prenumele artistului pe care doriti sa il adaugati" required>
                        </textarea>
                        </div><br/>
                        <input type="hidden" name="adaugaGenMuzical" value="true"/>
                        <div>
                            <input type="image" src="imgs/button_adauga-gen-muzical.png" alt="Submit"> 
                        </div>
                    </form>
                </div>
            </center>    
    </details>
    <h1 style="font-family: 'Your Desired Font', sans-serif;text-align:center;color:red;margin-top:50px">Administrare (Stergere)</h1>
     <hr style="border:1px solid red; width: 50%"/><br/>
     <details style="margin-top:1%;width:90%;text-align:center">
        <summary style="font-size:40px;background-color:red"> Sterge artist</summary>
        <center><div style="width:100%;padding-top:3%;padding-bottom:3%;background-color:white;">
                    <form id="register-form" action="restAPIs/playlistController.php" method="post">
                        <?php if (
                            isset($_GET["loginFailed"]) &&
                            $_GET["loginFailed"] == "true"
                        ) {
                            echo "<span style='color:red;font-size:20px'>Login failed. Please try again.</span>";
                        } ?>
                        <div>
                        <span style="display: block; text-align: center;">Artist: </span>
                            <select name="stergeArtistId" style="width:80%; height: 30px">
                                <?php foreach ($artisti as $artist) {
                                    echo "<option value=" .
                                        $artist->ArtistId .
                                        ">" .
                                        $artist->GetNumePrenume() .
                                        "</option>";
                                } ?>
                            </select>
                        </div><br/>
                        <div>
                        <input type="hidden" name="stergeArtist" value="true"/>
                        <div>
                            <input type="image" src="imgs/button_sterge-artist.png" alt="Submit"> 
                        </div>
                    </form>
                </div>
            </center>    
    </details>
    <details style="margin-top:1%;width:90%;text-align:center">
        <summary style="font-size:40px;background-color:red"> Sterge gen muzical </summary>
        <center><div style="width:100%;padding-top:3%;padding-bottom:3%;background-color:white;">
                    <form id="register-form" action="restAPIs/playlistController.php" method="post">
                        <?php if (
                            isset($_GET["loginFailed"]) &&
                            $_GET["loginFailed"] == "true"
                        ) {
                            echo "<span style='color:red;font-size:20px'>Login failed. Please try again.</span>";
                        } ?>
                    <div>
                    <span style="display: block; text-align: center;">Gen muzical: </span>
                        <select name="stergeGenMuzicalId" style="width:80%; height: 30px">
                            <?php foreach ($genuriMuzicale as $genMuzical) {
                                echo "<option value=" .
                                    $genMuzical->GenMuzicalId .
                                    ">" .
                                    $genMuzical->Denumire .
                                    "</option>";
                            } ?>
                        </select>
                    </div><br/>
                        <input type="hidden" name="stergeGenMuzical" value="true"/>
                        <div>
                            <input type="image" src="imgs/button_sterge-gen-muzical.png" alt="Submit"> 
                        </div>
                    </form>
                </div>
            </center>    
    </details>
    <br/><br/><br/>
    </center>

    </body>

    <script src="js/locatie.js"></script>
    <script>
        // Creez un web worker
        const worker = new Worker('ww/timeWebWorker.js');

        // Ascult mesajele provenite de la web worker
        worker.addEventListener('message', function(event) {
            // Actualizez interfata cu elementele primite de la Web Worker
            document.getElementById('ceas').textContent = event.data;
        });
</script>
<script>
    // Referinte catre inputul pentru text si fisier video
    var textVideo = document.getElementById('textVideo');
    var fisierVideo = document.getElementById('fisierVideo');

    // Adaug un event listener pentru inputul in textVideo
    textVideo.addEventListener('input', function () {
        // Daca text inputul nu este gol, se face disable la optiunea de a incarca fisier video
        fisierVideo.disabled = textVideo.value.trim() !== '';
    });
    fisierVideo.addEventListener('change', function () {
        // Daca un fisier video este selectat, se face disable la inputul pentru a specifica path-ul catre un fisier video
        textVideo.disabled = fisierVideo.files.length > 0;
    });
    // Referinte catre inputul pentru text si fisier versuri
    var textVersuri = document.getElementById('textVersuri');
    var fisierVersuri = document.getElementById('fisierVersuri');
    fisierVersuri.addEventListener('change', function () {
        // Daca un fisier este selectat, se face disable la optiunea de a specifica path-ul manual
        textVersuri.disabled = fisierVersuri.files.length > 0;
    });
    // Adaug event listener pentru inputul in textVersuri
    textVersuri.addEventListener('input', function () {
        // Daca inputul de text nu este gol, se face disable la optiunea de a alege un fisier.
        fisierVersuri.disabled = textVersuri.value.trim() !== '';
    });
    // Aceleasi lucruri se repeta si pentru thumbnail
    var textThumbnail = document.getElementById('textThumbnail');
    var fisierThumbnail = document.getElementById('fisierThumbnail');
    fisierThumbnail.addEventListener('change', function () {
        textThumbnail.disabled = fisierThumbnail.files.length > 0;
    });
    textThumbnail.addEventListener('input', function () {
        fisierThumbnail.disabled = textThumbnail.value.trim() !== '';
    });
</script>