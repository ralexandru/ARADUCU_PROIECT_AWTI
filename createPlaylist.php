<?php
include("db_manager.php");

$databaseManager = new DatabaseManager('localhost', 'root', '', 'proiect_awti');

$melodii = $databaseManager->getAllMelodii();
$artisti = $databaseManager->getAllArtisti();
$playlist = $databaseManager->getPlaylist($_GET['playlistId']);
$melodiiPlaylist = $playlist[0]->melodii;
$genuriMuzicale = $databaseManager->getAllGenuriMuzicale();
// Stochez id-ul playlist-ului in variabila playlistId
echo '<script>';
echo 'var playlistId = ' . json_encode($playlist[0]->PlaylistId) . ';';
echo '</script>';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('db_functions.php');
    
    $nume= $_POST['numeUtilizator'];
    $parola = $_POST['parola'];

    if(loginUtilizator($nume, $parola)==true){
        session_start();
        $_SESSION['numeUtilizator'] = $nume;
        echo '<script>';
        echo 'localStorage.setItem("logat", "true");';
        echo 'localStorage.setItem("numeUtilizator", "'.$nume.'");';
        echo '</script>';
    }
    else{
        header("Location: login.php?loginFailed=true");
    }
}
?>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles/home.css">
        <link rel="stylesheet" href="styles/createPlaylist.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <link rel="stylesheet" href="styles/navbar.css">
        <link rel="icon" href="imgs/logo.svg" type="image/svg+xml">
        <title>Modifica playlist</title>
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
                echo '<script>';
                echo 'var isLoggedIn = localStorage.getItem("logat") === "true";';
                echo 'var nivelAcces = localStorage.getItem("nivelAcces");';

                echo 'if (!isLoggedIn) {';
                echo '    document.write(\'<a href="register.php" class="menuItem" width="100%" height="100%">Inregistrare</a>\');';
                echo '    document.write(\'<a href="login.php" class="menuItem" width="100%" height="100%">Login</a>\');';                
                echo '}';
                echo 'else{';
                echo '    document.write(\'<a href="login.php?logout=true" class="menuItem" width="100%" height="100%">Logout</a>\');';
                echo '    document.write(\'<a href="playlists.php" class="menuItem" width="100%" height="100%">Adauga playlist</a>\');';
                echo '    if (nivelAcces==1)';
                echo '      document.write(\'<a href="addSong.php" class="menuItem" width="100%" height="100%">Administrare</a>\');';
                echo '}';
                echo '</script>';
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
        <div id="content">
            <div id="titlu">
                <p id="denumirePlaylist" contenteditable="true" style="width:100%"><?php echo $playlist[0]->Denumire?></p>
                <hr style="width:80%"/>
            </div>
            <input type="button" style="width:200px;height:30px;background-color:green;color:white;font-size:15px;border: 1px solid white" onclick="salveazaDenumire()"value="Salveaza denumire"/><br/><br/>
            <div id="content2">
            <div id="melodiiNoPlaylist" style="" ondrop="drop(event)" ondragover="allowDrop(event)">
            <h1>Melodii care nu sunt in playlist</h1>
<!-- Melodii care nu se afla in playlist inca -->
<?php
$otherMelodiesIds = null;
if($melodiiPlaylist != null)
$otherMelodiesIds = array_column($melodiiPlaylist, 'MelodieId');
if(count($melodii) > 0){
foreach ($melodii as $melodie) {
    if($otherMelodiesIds != null)
    if (in_array($melodie->MelodieId, $otherMelodiesIds)) continue;
    $uniqueId = 'playButtonCanvas_' . $melodie->MelodieId; 
    $dragId = 'drag_' . $melodie->MelodieId; // ID unic pentru D&D

    echo '<div id="newsfeed" style="width:100%">';
    echo '    <div class="music" id="'.$melodie->MelodieId.'" style="max-height:200px" draggable="true" ondragstart="drag(event)" id="' . $dragId . '">';
    echo '        <div id="pictureMusic" style="height:150px">';
    echo '            <img src="' . $melodie->imgPath . '" draggable="false" style="width:100%;height:100%;" alt="Music Image"/>';
    echo '        </div>';
    echo '        <div id="songDetails">';
    echo '            <a style="font-size:20px; font-weight: bold;">Artist: ' . $artisti[array_search($melodie->ArtistId, array_column($artisti, "ArtistId"))]->GetNumePrenume() . '</a><br/>';
    echo '            <a style="font-size:20px; font-weight: bold;">Nume melodie: ' . $melodie->NumeMelodie . '</a><br/>';
    echo '            <a style="font-size:20px; font-weight: bold;">Gen: ' . $genuriMuzicale[array_search($melodie->GenMuzicalId,array_column($genuriMuzicale, "GenMuzicalId"))]->Denumire . '</a><br/>';
    echo '        </div>';
    echo '        <div id="songControls">';
    echo '            <canvas id="' . $uniqueId . '" data-songid="' . $melodie->MelodieId . '" width="50" height="50"></canvas>'; 
    echo '        </div>';
    echo '    </div>';
    echo '</div>';
}
}
?>     
</div>
<!-- Melodii care se afla in playlist -->
<div id="melodiiPlaylist" ondrop="drop(event)" ondragover="allowDrop(event)">
<h1>Melodii care sunt in playlist</h1>

<?php
    if($melodiiPlaylist != null){
        foreach ($melodiiPlaylist as $melodie) {
            $uniqueId = 'playButtonCanvas_' . $melodie["MelodieId"];
            $dragId = 'drag_' . $melodie["MelodieId"];; // ID unic pentru D&D
            echo '<div id="newsfeed" style="width:100%">';
            echo '    <div class="music" id="'.$melodie["MelodieId"].'" style="max-height:200px" draggable="true" ondragstart="drag(event)" id="' . $dragId . '">';
            echo '        <div id="pictureMusic" style="height:150px">';
            echo '            <img src="' . $melodie["imgPath"] . '" draggable="false" style="width:100%;height:100%;" alt="Music Image"/>';
            echo '        </div>';
            echo '        <div id="songDetails">';
            echo '            <a style="font-size:20px; font-weight: bold;">Artist: ' . $artisti[$melodie["ArtistId"]-1]->GetNumePrenume() . '</a><br/>';
            echo '            <a style="font-size:20px; font-weight: bold;">Nume melodie: ' . $melodie["NumeMelodie"] . '</a><br/>';
            echo '            <a style="font-size:20px; font-weight: bold;">Gen: ' . $genuriMuzicale[$melodie["GenMuzicalId"]-1]->Denumire . '</a><br/>';
            echo '        </div>';
            echo '        <div id="songControls">';
            echo '            <canvas id="' . $uniqueId . '" data-songid="' . $melodie["MelodieId"]. '" width="50" height="50"></canvas>'; // Use the unique id
            echo '        </div>';
            echo '    </div>';
            echo '</div>';
        }
    }
?> 
</div>
            </div>
        </div>
    <script>
        function salveazaDenumire() {
    // Preiau continutul elementului contentEditable(titlu playlist)
    var denumirePlaylist = $("#denumirePlaylist").text();

    // Folosesc AJAX ca sa trimit un API request pentru a schimba titlul
    $.ajax({
        type: "POST",
        url: "restAPIs/playlistController.php",
        data: { 
            action: 'schimbaDenumire',
            playlistId: playlistId,
            denumire: denumirePlaylist },
        success: function(response) {
            console.log(response);
        },
        error: function(error) {
            console.error(error);
        }
    });
}
function allowDrop(ev)
{
ev.preventDefault();
}

function drag(ev)
{
ev.dataTransfer.setData("Text",ev.target.id);
}

function drop(ev)
{
ev.preventDefault();
var data=ev.dataTransfer.getData("Text");
ev.target.appendChild(document.getElementById(data));
var draggedElementId = document.getElementById(data).id;
    // Verific targetul
    if (ev.target.id === "melodiiNoPlaylist") {
        // Daca elementul a fost plasat in melodiiNoPlaylist
        alert(draggedElementId+"Dropped into melodiiNoPlaylist");
        stergeMelodiePlaylist(playlistId,draggedElementId);
    } else if (ev.target.id === "melodiiPlaylist") {
        // Daca elementul a fost plasat in melodiiPlaylist
        alert(draggedElementId+"Dropped into melodiiPlaylist");
        adaugaMelodiePlaylist(playlistId,draggedElementId);
    }
}

function adaugaMelodiePlaylist(playlistId, melodieId) {
    $.ajax({
        type: 'POST',
        url: 'restAPIs/playlistController.php',
        data: {
            action: 'adaugaMelodiePlaylist',
            playlistId: playlistId,
            melodieId: melodieId
        },
        success: function(response) {
            var result = JSON.parse(response);
            alert(result);
            if (result.success) {
                console.log('Melodie added to playlist successfully');
            } else {
                console.error('Failed to add melodie to playlist');
            }
        },
        error: function() {
            console.error('Error during AJAX request');
        }
    });
}

function stergeMelodiePlaylist(playlistId, melodieId) {
    $.ajax({
        type: 'POST',
        url: 'restAPIs/playlistController.php',
        data: {
            action: 'stergeMelodiePlaylist',
            playlistId: playlistId,
            melodieId: melodieId
        },
        success: function(response) {
            var result = JSON.parse(response);
            alert(result); 
            if (result.success) {
                console.log('Melodie removed from playlist successfully');
            } else {
                console.error('Failed to remove melodie from playlist');
            }
        },
        error: function() {
            console.error('Error during AJAX request');
        }
    });
}
    </script>
</body>
<script src="js/locatie.js"></script>
<script>
        // Creez un web worker
        const worker = new Worker('ww/timeWebWorker.js');

        // Ascult mesajele primite de la web worker
        worker.addEventListener('message', function(event) {
            // Actualizez timpul in interfata cu valorile primite de la web worker
            document.getElementById('ceas').textContent = event.data;
        });
</script>