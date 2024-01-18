<?php
include "db_manager.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "db_functions.php";

    $nume = $_POST["numeUtilizator"];
    $parola = $_POST["parola"];

    $utilizator = loginutilizator($nume, $parola);
    if (strlen($utilizator->NumeUtilizator > 0)) {
        session_start();
        $_SESSION["numeUtilizator"] = $utilizator->NumeUtilizator;
        // Setez statusul pentru login in localStorage
        echo "<script>";
        echo 'localStorage.setItem("logat", "true");';
        echo 'localStorage.setItem("numeUtilizator", "' . $nume . '");';
        echo 'localStorage.setItem("nivelAcces", "' .
            $utilizator->nivelAcces .
            '");';

        echo "</script>";
    } else {
        header("Location: login.php?loginFailed=true");
    }
}
$databaseManager = new DatabaseManager("localhost", "root", "", "proiect_awti");

if (isset($_GET["genMuzicalId"]) && $_GET["genMuzicalId"] != 0) {
    $melodii = $databaseManager->getAllMelodiiGen($_GET["genMuzicalId"]);
} else {
    $melodii = $databaseManager->getAllMelodii();
}
$artisti = $databaseManager->getAllArtisti();
$genuriMuzicale = $databaseManager->getAllGenuriMuzicale();
?>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles/home.css">
        <link rel="stylesheet" href="styles/navbar.css">
        <link rel="stylesheet" href="styles/floatingArrow.css">
        <link rel="icon" href="imgs/logo.svg" type="image/svg+xml">
        <title>Acasa</title>
    </head>
    <body>
        <div id="navbar">
            <a href="home.php" class="logo" width="100%" height="100%">
            <svg href="home.php" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" width="100%" height="100%" style="background-color: black;">
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
        <div id="noutati" style="width:100%; background-color: green; color:white">
            <marquee style="font-size:20px" id="noutate"></marquee>
        </div>
        <div id="title" style="width:100%;">
        <h1>Melodii</h1>
        <hr id="divider"/><br/></div>
        <div id="filtre" style="align-items:center">
        <center>
            <form action="home.php" id="formFiltru" method="get">
            <span style="display: block; text-align: center;">Gen muzical: </span>
                <select name="genMuzicalId" onChange="aplicaFiltru()" style="width:50%; height: 30px">
                    <option value='0'>Toate genurile</option>
                    <?php foreach ($genuriMuzicale as $genMuzical) {
                        if (
                            isset($_GET["genMuzicalId"]) &&
                            $genMuzical->GenMuzicalId == $_GET["genMuzicalId"]
                        ) {
                            echo "<option value=" .
                                $genMuzical->GenMuzicalId .
                                " selected>" .
                                $genMuzical->Denumire .
                                "</option>";
                        } else {
                            echo "<option value=" .
                                $genMuzical->GenMuzicalId .
                                ">" .
                                $genMuzical->Denumire .
                                "</option>";
                        }
                    } ?>
                </select>
            </form>
         </center>
        </div>
        <div id="newsfeed" style="width:100%">
        <?php foreach ($melodii as $melodie) {
            $uniqueId = "playButtonCanvas_" . $melodie->MelodieId; // Genereaza un ID unic
            echo '<div id="newsfeed" style="width:100%">';
            echo '    <div id="music" style="max-height:200px;">';
            echo '        <div id="pictureMusic" style="height:150px">';
            echo '            <img src="' .
                $melodie->imgPath .
                '" style="width:100%;height:100%;" alt="Music Image"/>';
            echo "        </div>";
            echo '        <div id="songDetails">';
            echo "            <a>Artist: " .
            $artisti[
                array_search(
                    $melodie->ArtistId,
                    array_column($artisti, "ArtistId")
                )
            ]->GetNumePrenume() . "</a><br/>";
            echo "            <a>Nume melodie: " .
                $melodie->NumeMelodie .
                "</a><br/>";
            echo "            <a>Gen: " .
                $genuriMuzicale[
                    array_search(
                        $melodie->GenMuzicalId,
                        array_column($genuriMuzicale, "GenMuzicalId")
                    )
                ]->Denumire .
                //$genuriMuzicale[$melodie->GenMuzicalId-1]->Denumire .
                "</a><br/>";
            echo "        </div>";
            echo '        <div id="songControls">';
            echo '            <canvas id="' .
                $uniqueId .
                '" data-songid="' .
                $melodie->MelodieId .
                '" width="50" height="50"></canvas>'; // Folosesc ID-ul unic
            echo "        </div>";
            echo "    </div>";
            echo "</div>";
            echo "<br/>";
        } ?>  
            <br/>           
            <button id="floating-button" onClick="back()">
    <div id="arrow"></div>
    Back to previous page
  </button>

    </body>
    <script>
         const playlistElement = document.getElementById('noutate');
        const eventSource = new EventSource('sse.php');

eventSource.onmessage = function (event) {
    const data = JSON.parse(event.data);
    noutate.textContent = `Ultima melodie melodie adaugata este: ${data.NumeMelodie}`;
};

eventSource.onerror = function (error) {
    console.error('EventSource failed:', error);
    eventSource.close();
};
        </script>
    <script>
function back() {
  window.history.back();
}
    </script>
    <script>
    function aplicaFiltru() {
        var formFiltru = document.getElementById("formFiltru");

        formFiltru.submit();
    }
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('canvas').forEach(function(canvas) {
            var context = canvas.getContext('2d');

            function drawPlayButton() {
                context.beginPath();
                context.moveTo(10, 10);
                context.lineTo(40, 25);
                context.lineTo(10, 40);
                context.closePath();
                context.fillStyle = '#000';
                context.fill();
            }
            // Cod explicat in playlists.php
            drawPlayButton();

            function handleClick() {
                var songId = canvas.getAttribute('data-songid');
                window.location.href = 'melodie.php?idMelodie=' + songId;
            }
            canvas.addEventListener('click', handleClick);
        });
    });
</script>
<script>
        // Creez un nou Web Worker
        const worker = new Worker('ww/timeWebWorker.js');

        // Asculta mesajele din partea acestuia
        worker.addEventListener('message', function(event) {
            // Actualizeaza interfata cu timpul primit de la acesta
            document.getElementById('ceas').textContent = event.data;
        });
</script>
<script src="js/locatie.js"></script>

