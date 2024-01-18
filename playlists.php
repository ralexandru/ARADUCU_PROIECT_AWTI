<?php
session_start();
include "db_manager.php";

$numeUtilizator = $_SESSION["numeUtilizator"];
$databaseManager = new DatabaseManager("localhost", "root", "", "proiect_awti");
$playlisturi = $databaseManager->getPlaylists($numeUtilizator);
$artisti = $databaseManager->getAllArtisti();

?>

<head>
    <style>
        body {
            margin: 0;
        }

        #roundedCanvas {
            position: fixed;
            bottom: 20px;
            right: 20px;
            border-radius: 50px;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/navbar.css">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/hideDetails.css">
    <link rel="stylesheet" href="styles/modalWindow.css">
    <link rel="stylesheet" href="styles/playlists.css">
    <link rel="icon" href="imgs/logo.svg" type="image/svg+xml">
    <title>Playlisturi</title>
</head>

<body>
    <div id="navbar">
        <a href="#" class="logo" width="100%" height="100%">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" width="100%" height="100%" style="background-color: black;">
                <rect width="100%" height="100%" fill="black" stroke="white" stroke-width="1" />
                <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="Arial" font-size="16">StreamMusic</text>
            </svg>
        </a>
        <a href="home.php" class="menuItem" width="100%" height="100%">Home</a> <?php
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
            ?> <a href="aboutUs.php" class="menuItem" width="100%" height="100%">Despre noi</a>
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
    <div id="title" style="width:100%;margin-top:5%">
        <h1>Playlisturi</h1>
        <hr id="divider" /><br />
    </div>
    <center> <?php if (count($playlisturi) < 1) {
                echo "Nu aveti playlisturi create!";
            } else {
                foreach ($playlisturi as $playlist) {
                    $count = 1;
                    $uniqueId = "crayonCanvas" . $playlist->PlaylistId;
                    echo '<div style="width:80%;background-color:white;">';
                    echo '<canvas id="' .
                    $uniqueId .
                    '" data-playlistId="' .
                    $playlist->PlaylistId .
                    '" width="50" height="50"></canvas>';
                    echo '    <div style="max-height:auto; border: 1px solid #ddd;padding-top:10px ">';
                    echo '            <a style="font-size:20px; font-weight: bold;">Titlu: </a><span>' .
                        $playlist->Denumire .
                        "</span><br/>";
                    echo '            <a style="font-size:20px; font-weight: bold;">Numar melodii: </a><span>' .
                        count($playlist->melodii) .
                        "</span><br/>";
                    echo '            <img src="imgs/edit-playlist.png" id="playlistButton" onclick="editPlaylist(' .
                        $playlist->PlaylistId .
                        ')"/>';
                    echo '            <img src="imgs/delete-playlist.png" id="playlistButton" onclick="deletePlaylist(' .
                        $playlist->PlaylistId .
                        ')"/>';

                    echo "            <br/>";
                    echo '            <details id="melodii" style="margin-top:10px;margin-bottom:10px;">';
                    echo '              <summary onclick="toggleBorder(this)">Melodii</summary>';
                    echo '              <div class="contentMelodii" style="overflow-y: auto">'; 
                    foreach ($playlist->melodii as $melodie) {
                        echo '              <div class="termeniConditii" style="background-color:white; border: 1px solid white; padding: 10px; text-align: justify;">';
                        // Afisez numele artistului si al melodiei
                        echo "              <p>".$count.". ".$artisti[$melodie["ArtistId"] - 1]->GetNumePrenume()." - ".$melodie["NumeMelodie"]."</p>";
                        echo "          </div>";
                        $count++;
                    }

                    echo "            </details>";
                    echo "      </div>";
                    echo "</div>";
                    echo "<br/>";
                }
            } ?> </center>
    <canvas href="#openModal" id="roundedCanvas" width="50" height="50" style="border-radius:50px">dasda</canvas>
    <div id="openModal" class="modalWindow" style="width:100%">
        <div>
            <div class="modalHeader">
                <h2>Create new playlist</h2>
            </div>
            <div class="modalContent">
                <p>Insert playlist name:</p>
                <form action="restAPIs/playlistController.php" method="get">
                    <input type="text" name="numePlaylist" style="width:100%"> </input>
                    <input type="hidden" name="numeUtilizator" value="<?php echo $numeUtilizator; ?>">
                    <br /><br />
                    <a href="#cancel" title="Cancel" class="cancel" style="width:40%">Cancel</a>
                    <input type="submit" href="#ok" title="Ok" class="ok" style="width:40%" alt="Submit">
                </form>
                <div class="clear"></div>
                <br />
            </div>
        </div>
    </div>
    <script>
        document.getElementById('roundedCanvas').addEventListener('click', function() {
            document.getElementById('openModal').style.opacity = 1;
            document.getElementById('openModal').style.pointerEvents = 'auto';
        });
        document.querySelectorAll('.close, .cancel').forEach(function(element) {
            element.addEventListener('click', function() {
                document.getElementById('openModal').style.opacity = 0;
                document.getElementById('openModal').style.pointerEvents = 'none';
            });
        });

        function toggleBorder(element) {
            const playlistBox = element.nextElementSibling;
            playlistBox.style.border = playlistBox.style.border ? '' : '1px solid #ddd';
        }

        function editPlaylist(playlistId) {
            // Redirectioneaza catre createPlaylist.php si creeaza playlistul
            window.location.href = 'createPlaylist.php?playlistId=' + playlistId;
        }

        function deletePlaylist(playlistId) {
            // Redirectioneaza catre playlistController.php si sterge playlistul
            window.location.href = 'restAPIs/playlistController.php?playlistDeleteId=' + playlistId;
        }
        document.addEventListener("DOMContentLoaded", function() {
            var canvas = document.getElementById("roundedCanvas");
            var buttonEdit = document.getElementById("roundedCanvas");
            var ctx = canvas.getContext("2d");
            // Culoare background pentru canvas
            ctx.fillStyle = "black";
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            // Un plus alb
            ctx.fillStyle = "white";
            ctx.fillRect(20, 5, 10, 40); // Bara verticala
            ctx.fillRect(5, 20, 41, 10); // Bara orizontala
            function createNewPlaylist() {
                // Primesc ID-ul melodiei din atributul data-songid
                var songId = canvas.getAttribute('data-songid');
                // Redirectionare catre createPlaylist.php
                window.location.href = 'createPlaylist.php';
            }
        });
    </script>
</body>
<script src="js/locatie.js"></script>
<script>
    // Creare Web Worker
    const worker = new Worker('ww/timeWebWorker.js');
    // Asculta mesaje de la web worker
    worker.addEventListener('message', function(event) {
        // Modifica timpul afisat in interfata in functie de mesajele de la web worker
        document.getElementById('ceas').textContent = event.data;
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Itereaza prin toate elementele canvasului
        document.querySelectorAll('canvas').forEach(function(canvas) {
            var context = canvas.getContext('2d');
            if (canvas.id === 'roundedCanvas') {
                // Daca id-ul canvasului nu este roundedCanvas, se va trece la urmatorul
                return;
            }
            // Deseneaza un buton de play
            function drawPlayButton() {
                context.beginPath();
                context.moveTo(10, 10);
                context.lineTo(40, 25);
                context.lineTo(10, 40);
                context.closePath();
                context.fillStyle = '#000';
                context.fill();
            }
            
            drawPlayButton();
            
            function handleClick() {
                // Preiau ID-ul playlist-ului din atributul data-playlistId
                var playlistId = canvas.getAttribute('data-playlistId');
                // Redirectionez catre melodie.php trimitand si id-ul playlistului
                window.location.href = 'melodie.php?idPlaylist=' + playlistId + "&index=0";
            }
            canvas.addEventListener('click', handleClick);
        });
    });
</script>