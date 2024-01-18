<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "db_functions.php";
    $nume = $_POST["numeUtilizator"];
    $parola = $_POST["parola"];

    if (loginUtilizator($nume, $parola) == true) {
    } else {
        header("Location: login.php?loginFailed=true");
    }
} ?>
    <style>
        body {
            position: relative;
            overflow-horizontal: hidden; 
        }

        canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            opacity: 0.5;
            pointer-events: none;
        }

        #aboutUsContainer {
            width: 90%;
            text-align: center;
            
        }
    </style>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles/register.css">
        
        <link rel="stylesheet" href="styles/navbar.css">
        <link rel="icon" href="imgs/logo.svg" type="image/svg+xml">
        <title>Despre noi       </title>
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
                    <center>
        <div id="aboutUsContainer" style="margin-top:0px">
            <img src="imgs/logo.svg" style="height: 200px; width: 200px; margin-top: 0px;margin-top:30px">
            <hr style="border: 1px solid black; width: 60%;">
            <br/>
            <a style="text-align: justify; display: inline-block; font-size: 20px; margin-bottom: 200px;">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque consectetur lacinia velit vel lacinia. Curabitur eu leo id odio efficitur aliquam eget in velit. Maecenas eu imperdiet augue, vel rhoncus tellus. Nunc rhoncus ac elit non imperdiet. Sed in efficitur turpis. Mauris fermentum sed massa eget sagittis. Etiam convallis, nunc non placerat efficitur, erat sem condimentum elit, in ultrices risus arcu sit amet metus. Aliquam cursus tempus lorem, ut tincidunt ipsum commodo sit amet. Aenean libero ipsum, suscipit imperdiet orci cursus, faucibus condimentum libero. Proin sit amet lacus at turpis commodo auctor id et mauris. Pellentesque rhoncus mollis placerat. Etiam posuere aliquam magna, in semper nisi faucibus eget. Fusce interdum maximus neque sed vestibulum. Curabitur sed diam in lacus dapibus laoreet. Aenean justo magna, eleifend feugiat tincidunt at, iaculis id felis. Integer gravida nisl sed neque consectetur porttitor. Ut volutpat eu massa venenatis mollis. Nam eu dignissim mi, vitae mollis nisl. Suspendisse sit amet gravida tortor, vitae laoreet justo. Pellentesque porta fermentum enim. Integer vel lectus in nibh luctus hendrerit at eu odio. Curabitur volutpat finibus orci in hendrerit. Cras eget nisi libero. Cras varius odio vel enim imperdiet, nec vestibulum ante aliquam. Maecenas fermentum lacus enim, ut malesuada leo lacinia in. Maecenas consequat sed felis ut consectetur. Sed nec arcu ante. Duis sagittis dui tincidunt, viverra metus sed, consequat lectus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vivamus auctor neque at lectus ultricies, sit amet accumsan orci sollicitudin. Vivamus sit amet turpis ac elit congue commodo vel ac tellus. Nunc cursus condimentum felis. Sed ut tellus vitae nulla fermentum finibus. Pellentesque fringilla urna sed nulla consectetur, vel vehicula felis tincidunt. Sed varius fringilla dolor et ultrices. Aenean efficitur quis mauris quis volutpat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Sed erat sapien, fringilla a turpis ac, imperdiet aliquet lorem. Cras dapibus felis magna, vel semper ex elementum eu. Phasellus mollis lacus ante, non faucibus urna varius at. Ut lacinia libero arcu. Vestibulum tempus velit quis purus interdum facilisis. Donec sed sagittis nibh, pulvinar sagittis velit. Sed aliquet elementum lectus consectetur sodales. Sed eu urna vel sapien iaculis sagittis. Pellentesque vestibulum lacus quam. Etiam vestibulum congue purus sed accumsan. Etiam dictum nibh quis justo mollis lacinia. Mauris venenatis sodales ligula, ut suscipit leo commodo et. Pellentesque eu blandit dolor, nec egestas ligula. Pellentesque pellentesque ligula vitae dapibus porttitor. Nullam suscipit diam quis velit efficitur fermentum.s
            </a>
            <canvas id="musicCanvas" width="1000" height="500"style="opacity:0.8"></canvas>
        </div></center>
    </body>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var canvas = document.getElementById('musicCanvas');
            var context = canvas.getContext('2d');

            var musicalNotes = [];

            // Functie pentru a crea o nota muzicala
            function createMusicalNote() {
                return {
                    x: Math.random() * canvas.width,
                    y: canvas.height,
                    size: Math.random() * 1 + 6, // Marime random
                    speed: Math.random() * 1 + 1 // Viteza random
                };
            }

            // Functie pentru a desena o nota muzicala
            function drawMusicalNote(musicalNote) {
                context.beginPath();
                context.moveTo(musicalNote.x, musicalNote.y - musicalNote.size * 2.5);
                context.lineTo(musicalNote.x, musicalNote.y - musicalNote.size * 0.5);
                context.arc(musicalNote.x + musicalNote.size * 0.5, musicalNote.y - musicalNote.size * 0.5, musicalNote.size * 0.5, Math.PI,3.1, false);
                context.stroke();
                context.fill();
            }

            // Functie pentru a anima desenul
            function update() {
                // Curat canvasul
                context.clearRect(0, 0, canvas.width, canvas.height);

                // Creez o noua nota muzicala cu o probabilitate random
                if (Math.random() < 0.03) {
                    musicalNotes.push(createMusicalNote());
                }

                // Actualizez si desenez fiecare nota muzicala
                for (var i = 0; i < musicalNotes.length; i++) {
                    var musicalNote = musicalNotes[i];
                    musicalNote.y -= musicalNote.speed;

                    // Desenez nota muzicala
                    drawMusicalNote(musicalNote);

                    // Inlatur/sterg notele muzicale care parasesc canvasul
                    if (musicalNote.y < -musicalNote.size * 1.5) {
                        musicalNotes.splice(i, 1);
                        i--;
                    }
                }

                // Request pentru urmatorul frame de animatie
                requestAnimationFrame(update);
            }

            // Pornesc animatia
            update();
        });
    </script>
    <script src="js/locatie.js"></script>
    <script>
        // Creez un nou web worker
        const worker = new Worker('ww/timeWebWorker.js');

        // Ascult mesajele din partea web workerului
        worker.addEventListener('message', function(event) {
            // Actualizez timpul afisat in interfata in functie de mesajele de la web worker
            document.getElementById('ceas').textContent = event.data;
        });
</script>