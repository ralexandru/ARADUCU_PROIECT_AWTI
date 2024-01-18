<?php
include "db_manager.php";

//if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //  include "db_functions.php";
   // $nume = $_POST["numeUtilizator"];
   // $parola = $_POST["parola"];

    // Call the function to add the user
   // if (loginUtilizator($nume, $parola) == true) {
   // } else {
   //     header("Location: login.php?loginFailed=true");
   // }
// }
$databaseManager = new DatabaseManager("localhost", "root", "", "proiect_awti");
// Melodia nu este rulata dintr-un playlist
if(isset($_GET["idMelodie"])){
    $melodie = $databaseManager->getMelodie($_GET["idMelodie"]);
    echo "<script>";
    echo "var melodieId = " . $melodie->MelodieId . ";";
    echo "</script>";
} // Melodia este rulata dintr-un playlist si trebuie sa stochez id-urile melodiilor care fac parte din playlist pentru a le rula pe rand
else if(isset($_GET["idPlaylist"])){
    $playlist = $databaseManager->getPlaylist($_GET["idPlaylist"]);
    $melodii = $playlist[0]->melodii;
    if($melodii != null)
        $melodiesIDs = array_column($melodii, 'MelodieId');
    if($_GET["index"]<count($melodii)){
        $melodie = $melodii[$_GET["index"]];
        $melodie = $databaseManager->getMelodie($melodiesIDs[$_GET["index"]]);
        echo "<script>";
        echo "var indexId = " . $_GET["index"] . ";";
        echo "var idPlaylist = " . $_GET["idPlaylist"] . ";";
        echo "var melodieId = " . $melodiesIDs[$_GET["index"]] . ";";
        echo "</script>";    
    }else{
        header("Location: 404NotFound.php");
    }
}
?>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles/navbar.css">
        <link rel="icon" href="imgs/logo.svg" type="image/svg+xml">
        <title>Muzica</title>
        <style>
            body{
   
            }
        </style>
    </head>
    <body style="background-color:black">
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
        <div id="melodieContainer" style="width:100%;text-align:center;margin-top:50px">
        <video id="melodie" width="40%" autoplay loop=2 poster="<?php echo $melodie->imgPath; ?>" onerror="failed(event)">
            <source src="<?php echo $melodie->Video; ?>" type="video/mp4">
            <track src="<?php echo $melodie->VersuriPath; ?>" label="English subtitles" kind="subtitles" srclang="en" default>
            Browser-ul dumneavoastra nu suporta HTML5 video.
        </video>
        </div>
        <div id="stats" style="text-align:center;margin-top:20px">
            <a style="color: white; font-size:23px;font-weight: bold">Timp petrecut ascultand muzica: </a><a style="color:white;font-size:20px" id="seconds">Ai ascultat pana acum 129 minute.</a>
        </div>

        <div id="controls" style="text-align:center">
            <canvas id="melodiaTrec" width="100" height="100"></canvas>
            <canvas id="playStopCanvas" width="100" height="100"></canvas>
            <canvas id="fullScreen" width="100" height="100"></canvas>
            <canvas id="deleteMelodie" width="100" height="100"></canvas>
            <canvas id="plus10s" width="100" height="100"></canvas>
            <canvas id="minus10s" width="100" height="100"></canvas>
            <canvas id="melodiaUrm" width="100" height="100"></canvas>

        </div>

    </body>
    <script type="text/javascript">
function ChangeUrl(title, url) {
    if (typeof (history.pushState) != "undefined") {
        var obj = { Title: title, Url: url };
        history.pushState(obj, obj.Title, obj.Url);
    } else {
        alert("Browser does not support HTML5.");
    }
}
</script>
<script>
function formatTime(seconds) {
  const hours = Math.floor(seconds / 3600);
  const minutes = Math.floor((seconds % 3600) / 60);
  const remainingSeconds = seconds % 60;

  const formattedTime = `${padZero(hours)}:${padZero(minutes)}:${padZero(remainingSeconds)}`;
  return formattedTime;
}

function padZero(value) {
  return value < 10 ? `0${value}` : value;
}
    var timpAscultat = localStorage.getItem('secondsCount');
    if (typeof(Worker) !== "undefined") {
        // Browserul stie de web workeri

        // Creez un nou web worker
        const myWorker = new Worker('ww/timpAscultatWebWorker.js');

        // Ascult mesaje de la web worker
        myWorker.onmessage = function(event) {
            // Convertesc timpul ascultat in int
            let timpAscultatAsNumber = parseInt(timpAscultat, 10) || 0;

            // Convertesc informatia de la web worker in int
            let eventDataAsNumber = parseInt(event.data, 10) || 0;

            // Adun cele doua pentru a afla timpul total ascultat pe platforma
            let result = timpAscultatAsNumber + eventDataAsNumber;

            // Convertesc rezultatul intr-un string
            let secundeAscultate = result.toString();
            const formattedTime = formatTime(result);
            // Actualizez timpul afisat
            const secondsElement = document.getElementById('seconds');
            secondsElement.textContent = formattedTime;

            // Stochez in localStorage valoarea noua
            localStorage.setItem('secondsCount', result);
        };

    } else {
      console.error('Web Workers are not supported in this browser.');
    }
  </script>
   <script>
    var video = document.getElementById('melodie');
    video.addEventListener('canplay', function() {
  var videoDuration = video.duration;
  console.log('Video duration:', videoDuration);

  setTimeout(function() {
    console.log('Redirecting after timeout');
    if(typeof indexId == 'undefined')
        window.location.href = 'https://localhost/proiect_awti/melodie.php?idMelodie=' + (melodieId+1);
    else
        window.location.href = 'https://localhost/proiect_awti/melodie.php?idPlaylist=' + idPlaylist + "&index=" + (indexId+1);

  }, videoDuration * 1000);

  var videoDuration = video.duration;
    console.log('Video duration:', videoDuration);

    function checkEnd() {
      // Verific daca timpul de rulare este aproape de final
      if (Math.abs(video.currentTime - videoDuration) < 0.1) {
        console.log('Video manually scrolled to the end. Redirecting...');
        if(typeof indexId == 'undefined')
            window.location.href = 'https://localhost/proiect_awti/melodie.php?idMelodie=' + (melodieId+1);
        else
            window.location.href = 'https://localhost/proiect_awti/melodie.php?idPlaylist=' + idPlaylist + "&index=" + (indexId+1);      
        } else {
        requestAnimationFrame(checkEnd);
      }
    }
    checkEnd();
});
  </script>
    <script>
        const canvasPlayStop = document.getElementById('playStopCanvas');
        const canvasFullScreen = document.getElementById('fullScreen');
        const canvasDelete = document.getElementById('deleteMelodie');
        const plus10s = document.getElementById('plus10s');
        const minus10s = document.getElementById('minus10s');
        const melodiaUrm = document.getElementById('melodiaUrm');
        const melodiaTrec = document.getElementById('melodiaTrec');

        const ctx = canvasPlayStop.getContext('2d');
        const ctxFullScreen = canvasFullScreen.getContext('2d');
        const ctxDelete = canvasDelete.getContext('2d');
        const ctxPlus10s = plus10s.getContext('2d');
        const ctxMinus10s = minus10s.getContext('2d');
        const ctxMelodiaUrm = melodiaUrm.getContext('2d');
        const ctxMelodiaTrec = melodiaTrec.getContext('2d');


        var melodie=document.getElementById("melodie"); 
        let isPlaying = false;
        ctxFullScreen.strokeStyle = '#ffffff';
        ctxFullScreen.lineWidth = 5;

        ctxDelete.fillStyle = 'red';
        ctxDelete.fillRect(0, 0, canvasDelete.width, canvasDelete.height);

        ctxDelete.strokeStyle = 'white';
        ctxDelete.lineWidth = 5;

        ctxDelete.beginPath();
        ctxDelete.moveTo(10, 10);
        ctxDelete.lineTo(90, 90);
        ctxDelete.stroke();

        ctxDelete.beginPath();
        ctxDelete.moveTo(90, 10);
        ctxDelete.lineTo(10, 90);
        ctxDelete.stroke();
        ctxFullScreen.strokeRect(0, 0, 100, 100);

        ctxPlus10s.fillStyle = 'white';
        ctxPlus10s.fillRect(0, 0, plus10s.width, plus10s.height);
        ctxPlus10s.fillStyle = 'black';
        ctxPlus10s.font = "30px Arial";
        ctxPlus10s.textAlign = "center";
        ctxPlus10s.textBaseline = "middle";
        ctxPlus10s.fillText("+10S", 50, 50);

        ctxMinus10s.fillStyle = 'white';
        ctxMinus10s.fillRect(0, 0, plus10s.width, plus10s.height);
        ctxMinus10s.fillStyle = 'black';
        ctxMinus10s.font = "30px Arial";
        ctxMinus10s.textAlign = "center";
        ctxMinus10s.textBaseline = "middle";
        ctxMinus10s.fillText("-10S", 50, 50);

        ctxMelodiaUrm.fillStyle = 'white';
        ctxMelodiaUrm.fillRect(0, 0, melodiaUrm.width, melodiaUrm.height);
        ctxMelodiaUrm.fillStyle = 'black';
        ctxMelodiaUrm.beginPath();
        ctxMelodiaUrm.moveTo(10,50);
        ctxMelodiaUrm.lineWidth = 10;
        ctxMelodiaUrm.lineTo(70,50);
        ctxMelodiaUrm.lineTo(50,20);
        ctxMelodiaUrm.lineTo(80,50);
        ctxMelodiaUrm.lineTo(50,80);
        ctxMelodiaUrm.stroke();

        ctxMelodiaTrec.fillStyle = 'white';
        ctxMelodiaTrec.fillRect(0, 0, melodiaTrec.width, melodiaTrec.height);
        ctxMelodiaTrec.fillStyle = 'black';
        ctxMelodiaTrec.beginPath();
        ctxMelodiaTrec.moveTo(80,50);
        ctxMelodiaTrec.lineWidth = 10;
        ctxMelodiaTrec.lineTo(20,50);

        ctxMelodiaTrec.lineTo(50,80);
        ctxMelodiaTrec.lineTo(10,50);
        ctxMelodiaTrec.lineTo(50,20);
        ctxMelodiaTrec.stroke();

        function drawButton(color) {
            ctx.clearRect(0, 0, canvasPlayStop.width, canvasPlayStop.height);

            ctx.fillStyle = color;
            ctx.fillRect(0, 0, 100, 100);

            ctx.font = "30px Arial";
            ctx.fillStyle = "#ffffff";
            ctx.textAlign = "center";
            ctx.textBaseline = "middle";

            const buttonText = isPlaying ? "▶" : "■";
            ctx.fillText(buttonText, 50, 50);
        }
        canvasDelete.addEventListener('click',toggleDelete);
        function toggleDelete(){
            window.location.href = 'restAPIs/playlistController.php?melodieDeleteId='+melodieId;
        }
        // Functie ce transforma videoclipul in full screen
        function toggleFullscreen() {
            if (melodie.requestFullscreen) {
                melodie.requestFullscreen();
            } else if (melodie.mozRequestFullScreen) { // Firefox
                melodie.mozRequestFullScreen();
            } else if (melodie.webkitRequestFullscreen) { // Chrome, Safari si Opera
                melodie.webkitRequestFullscreen();
            } else if (melodie.msRequestFullscreen) { // IE/Edge
                melodie.msRequestFullscreen();
            }
        }
        canvasFullScreen.addEventListener('click', toggleFullscreen);
        function togglePlayStop() {
            isPlaying = !isPlaying;
            const buttonColor = isPlaying ? 'green' : 'red';
            drawButton(buttonColor);
            if (melodie.paused) 
                melodie.play(); 
            else 
                melodie.pause(); 
        }

        canvasPlayStop.addEventListener('click', togglePlayStop);
        plus10s.addEventListener('click',skipForward);
        minus10s.addEventListener('click',skipBackward);
        function skipForward() {
        var video = document.getElementById("melodie");
        if (video) {
            // Skip 10 secunde din video
            video.currentTime += 10;
        }
    }
    function skipBackward() {
        var video = document.getElementById("melodie");
        if (video) {
            // Skip backward 10 secunde din video
            video.currentTime -= 10;
        }
    }
        // Buton stop
        drawButton('red');

    function nextMelodie(){
        if(typeof indexId == 'undefined')
            window.location.href = 'https://localhost/proiect_awti/melodie.php?idMelodie=' + (melodieId+1);
        else
            window.location.href = 'https://localhost/proiect_awti/melodie.php?idPlaylist=' + idPlaylist + "&index=" + (indexId+1);      
    }
    melodiaUrm.addEventListener('click',nextMelodie);

    function prevMelodie(){
        if(typeof indexId == 'undefined' && (melodieId-1) > 0)
            window.location.href = 'https://localhost/proiect_awti/melodie.php?idMelodie=' + (melodieId-1);
        else if(indexId > 0)
            window.location.href = 'https://localhost/proiect_awti/melodie.php?idPlaylist=' + idPlaylist + "&index=" + (indexId-1);      
        

    }
    melodiaTrec.addEventListener('click',prevMelodie);

    </script>
<script src="js/locatie.js"></script>
<script>
        // Creez un nou Web Worker
        const worker = new Worker('ww/timeWebWorker.js');

        // Asculta mesajele din partea acestuia
        worker.addEventListener('message', function(event) {
            // Actualizeaza interfata cu timpul primit de la acesta
            document.getElementById('ceas').textContent = event.data;
        });
</script>