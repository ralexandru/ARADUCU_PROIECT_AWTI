
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/register.css">
    <link rel="stylesheet" href="styles/navbar.css">
    <link rel="icon" href="imgs/logo.svg" type="image/svg+xml">
    <title>Inregistrare</title>
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
            // Verific daca utilizatorul este logat si nivelul de acces al acestuia
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
    <div id="register-container" style="width:100%;margin-top:10%">
        <form id="register-form" action="login.php" method="post">
        <center>
            <?php if (
                isset($_GET["registerFailed"]) &&
                $_GET["registerFailed"] == "true"
            ) {
                echo "<span style='color:red;font-size:20px'>Registration failed. Please try again.</span>";
            } ?>
            <h1 style="font-family: 'Your Desired Font', sans-serif;">Register</h1>
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
            <div>
                <span style="display: block; text-align: center;">Email: </span> 
                <input type="email" name="adresaMail" style="width:80%; height: 30px" required>
            </div><br/>
            <div>
                <span style="display: block; text-align: center;">Nr. Telefon: </span>
                <input type="tel" name="nrTelefon" style="width:80%; height: 30px" pattern="[0-9]+" title="Va rugam introduceti un nr. de telefon valid care contine doar cifre de la 0 la 9">
            </div><br/>
            <div>
             <span style="display: block; text-align: center;">Data Nasterii:</span> 
                <input type="date" name="dataNastere" style="width:80%; height: 30px">
            </div><br/>
            <div>
                <span style="display: block; text-align: center;">Tara: </span>
                <select name="tara" style="width:80%; height: 30px">
                    <option value="Romania">Romania</option>
                    <option value="Romania">Anglia</option>
                    <option value="Romania">Franta</option>
                </select>
            </div><br/>
            <div>
                <span style="display: block; text-align: center;">Site web:</span>
                <input type="url" name="siteWeb" style="width:80%; height: 30px" pattern="https?://.*" title="Va rugam introduceti o adresa web valida care incepe cu 'http://' sau 'https://'" required>
            </div><br/>
            <div>
                <input type="checkbox" name="termeniConditii" required>
                Sunt de acord cu termenii si conditiile de utilizare!<br/><br/>
                <details>
                    <summary>Termeni si conditii de utilizare</summary>
                    <div class="termeniConditii" style="background-color:white; border: 1px solid black; padding: 10px;text-align: justify;">
                        <p>Prin bifarea casutei de mai sus va exprimati acordul cu privire la termenii si conditiile de utilizare ale acestui site web.</p>
                    </div>
                </details>    
            </div><br/>
            <input type="image" src="imgs/button_inregistreaza-te.png" alt="Submit"> 
            
        </center><br/>
        </form>
    </div>
</body>
<script src="js/locatie.js"></script>
<script>
        // Creez un Web Worker care afiseaza data
        const worker = new Worker('ww/timeWebWorker.js');

        // Ascult mesajele provenite de la web worker
        worker.addEventListener('message', function(event) {
            // Actualizez timpul afisat cu timpul primit de la acesta
            document.getElementById('ceas').textContent = event.data;
        });
</script>