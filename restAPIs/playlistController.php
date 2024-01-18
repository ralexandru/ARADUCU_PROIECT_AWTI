<?php
if (isset($_GET["playlistNumeUpdate"])) {
    UpdatePlaylistDenumire(
        $_GET["playlistIdUpdate"],
        $_GET["playlistNumeUpdate"]
    );
    echo "Se salveaza playlist-ul, vei fi redirectionat in 5 secunde...";
    header("refresh:5;url=https://localhost/proiect_awti/playlists.php");
} elseif (isset($_GET["playlistDeleteId"])) {
    StergePlaylist($_GET["playlistDeleteId"]);
    echo "Se sterge playlist-ul, vei fi redirectionat in 5 secunde...";
    header("refresh:5;url=https://localhost/proiect_awti/playlists.php");
} elseif (isset($_GET["melodieDeleteId"])) {
    StergeMelodie($_GET["melodieDeleteId"]);
    echo "Se sterge melodia, vei fi redirectionat in 5 secunde...";
    header("refresh:5;url=https://localhost/proiect_awti/");
} elseif (isset($_POST["adaugaMelodie"])) {
    if(isset($_POST["videoText"])){
        if (strlen($_POST["videoText"]) > 1) {
            $video = $_POST["videoText"];
        }
    }
    else {
        $video = "videos/" . $_POST["video"];
    }
    
    if (isset($_POST["versuriText"])) {
        $versuri = $_POST["versuriText"];
    } else {
        $versuri = "subs/" . $_POST["versuri"];
    }

    if (isset($_POST["thumbnailText"])) {
        $thumbnail = $_POST["thumbnailText"];
    } else {
        $thumbnail = "imgs/" . $_POST["thumbnail"];
    }

    CreateMelodie(
        $_POST["artist"],
        $_POST["denumireMelodie"],
        $_POST["genMuzical"],
        $video,
        $_POST["descriere"],
        $versuri,
        $thumbnail
    );
    echo "Se adauga melodia, vei fi redirectionat in 5 secunde...";
    header("refresh:5;url=https://localhost/proiect_awti/");
} elseif (isset($_POST["adaugaArtist"])) {
    CreateArtist($_POST["numeArtist"], $_POST["prenumeArtist"]);
    echo "Se adauga artistul, vei fi redirectionat in 5 secunde...";
    header("refresh:5;url=https://localhost/proiect_awti/");
} elseif (isset($_POST["adaugaGenMuzical"])) {
    CreateGenMuzical(
        $_POST["denumireGenMuzical"],
        $_POST["descriereGenMuzical"]
    );
    echo "Se adauga genul muzical, vei fi redirectionat in 5 secunde...";
    header("refresh:5;url=https://localhost/proiect_awti/");
} elseif (isset($_POST["stergeArtist"])) {
    StergeArtist($_POST["stergeArtistId"]);
    echo "Se sterge artistul, vei fi redirectionat in 5 secunde...";
    header("refresh:5;url=https://localhost/proiect_awti/");
} elseif (isset($_POST["stergeGenMuzical"])) {
    StergeGenMuzical($_POST["stergeGenMuzicalId"]);
    echo "Se sterge genum muzical, vei fi redirectionat in 5 secunde...";
    header("refresh:5;url=https://localhost/proiect_awti/");
} elseif (isset($_GET["numePlaylist"])) {
    CreatePlaylist($_GET["numePlaylist"], $_GET["numeUtilizator"]);
    echo "Se adauga playlistul, vei fi redirectionat in 5 secunde...";
    header("refresh:5;url=https://localhost/proiect_awti/playlists.php");
} else {
    // Verific daca requestul de AJAX contine parametrul action
    if (isset($_POST["action"])) {
        // Efectuez operatiunea mentionata in parametrul action
        $action = $_POST["action"];

        switch ($action) {
            case "schimbaDenumire":
                // Verific daca playlistId si denumire sunt setate
                if (isset($_POST["playlistId"]) && isset($_POST["denumire"])) {
                    $playlistId = $_POST["playlistId"];
                    $denumirePlaylist = $_POST["denumire"];

                    // Apelez functia de a modifica denumirea unui playlist
                    $success = UpdatePlaylistDenumire(
                        $playlistId,
                        $denumirePlaylist
                    );

                    // Returnez raspunsul JSON
                    header("Content-Type: application/json");
                    echo json_encode(["success" => $success]);
                    exit();
                } else {
                    // C
                    header("Content-Type: application/json");
                    echo json_encode([
                        "success" => false,
                        "message" => "Missing parameters",
                    ]);
                    exit();
                }
                break;
            case "adaugaMelodiePlaylist":
                // Verific daca parametrii playlistId si melodieId sunt setati
                if (isset($_POST["playlistId"]) && isset($_POST["melodieId"])) {
                    $playlistId = $_POST["playlistId"];
                    $melodieId = $_POST["melodieId"];

                    // Apelez functia de a adauga o melodie in playlist
                    $success = AdaugaMelodiePlaylist($playlistId, $melodieId);

                    // Returnez raspunsul JSON
                    header("Content-Type: application/json");
                    echo json_encode(["success" => $success]);
                    exit(); //
                } else {
                    // Cazul in care unul dintre parametrii nu este setat
                    header("Content-Type: application/json");
                    echo json_encode([
                        "success" => false,
                        "message" => "Missing parameters",
                    ]);
                    exit();
                }
                break;
            case "stergeMelodiePlaylist":
                // Verific daca parametrii playlistId si melodieId sunt setati
                if (isset($_POST["playlistId"]) && isset($_POST["melodieId"])) {
                    $playlistId = $_POST["playlistId"];
                    $melodieId = $_POST["melodieId"];

                    // Apelez functia de a sterge o melodie din playlist
                    $success = StergeMelodiePlaylist($playlistId, $melodieId);

                    // Returnez raspunsul JSON
                    header("Content-Type: application/json");
                    echo json_encode(["success" => $success]);
                    exit(); 
                } else {
                    // Cazul in care unul dintre parametrii nu este setat
                    header("Content-Type: application/json");
                    echo json_encode([
                        "success" => false,
                        "message" => "Missing parameters",
                    ]);
                    exit();
                }
                break;
            default:
                // Actiune invalida
                header("Content-Type: application/json");
                echo json_encode([
                    "success" => false,
                    "message" => "Invalid action",
                ]);
                exit();
        }
    } else {
        // Nu este definita nicio valoare pentru parametrul action
        header("Content-Type: application/json");
        echo json_encode([
            "success" => false,
            "message" => "No action specified",
        ]);
        exit();
    }
} ?>
<?php
function connectDB()
{
    $host = "localhost";
    $username = "root";
    $password = "";

    $database = "proiect_awti";
    $connection = mysqli_connect($host, $username, $password, $database);
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $connection;
}
function closeDatabaseConnection($connection)
{
    mysqli_close($connection);
}
function CreateArtist($numeArtist, $prenumeArtist)
{
    $connection = connectDB();
    $numeArtist = mysqli_real_escape_string($connection, $numeArtist);
    $prenumeArtist = mysqli_real_escape_string($connection, $prenumeArtist);
    $query = "INSERT INTO artist(Nume, Prenume) VALUES('$numeArtist','$prenumeArtist');";
    $result = mysqli_query($connection, $query); 
    $success = $result !== false; 
    closeDatabaseConnection($connection);
    return $success;
}
function CreateGenMuzical($denumire, $descriere)
{
    $connection = connectDB();
    $denumire = mysqli_real_escape_string($connection, $denumire);
    $descriere = mysqli_real_escape_string($connection, $descriere);
    $query = "INSERT INTO genmuzical(Denumire, Descriere) VALUES('$denumire','$descriere');"; 
    $result = mysqli_query($connection, $query);
    $success = $result !== false;
    closeDatabaseConnection($connection);
    return $success;
} 
function CreateMelodie(
    $ArtistId,
    $NumeMelodie,
    $GenMuzicalId,
    $Video,
    $Descriere,
    $VersuriPath,
    $imgPath
) {
    $connection = connectDB();
    $ArtistId = mysqli_real_escape_string($connection, $ArtistId);
    $NumeMelodie = mysqli_real_escape_string($connection, $NumeMelodie);
    $GenMuzicalId = mysqli_real_escape_string($connection, $GenMuzicalId);
    $Video = mysqli_real_escape_string($connection, $Video);
    $Descriere = mysqli_real_escape_string($connection, $Descriere);
    $VersuriPath = mysqli_real_escape_string($connection, $VersuriPath);
    $imgPath = mysqli_real_escape_string($connection, $imgPath);

    $query = "INSERT INTO melodie (ArtistId, NumeMelodie, GenMuzicalId, Video, Descriere, VersuriPath, imgPath) VALUES ($ArtistId, 
        '$NumeMelodie',$GenMuzicalId,'$Video','$Descriere', '$VersuriPath','$imgPath');"; 
    $result = mysqli_query($connection, $query);
    $success = $result !== false; 
    closeDatabaseConnection($connection);
    return $success;
} 
function CreatePlaylist($denumire, $numeUtilizator)
{
    $connection = connectDB();
    $denumire = mysqli_real_escape_string($connection, $denumire);
    $numeUtilizator = mysqli_real_escape_string($connection, $numeUtilizator);
    $query = "INSERT INTO playlist (Denumire, UtilizatorId) VALUES ('$denumire', (SELECT UtilizatorId FROM utilizatori WHERE NumeUtilizator='$numeUtilizator'));"; // Execute the query
    $result = mysqli_query($connection, $query); 
    $success = $result !== false; 
    closeDatabaseConnection($connection);
    return $success;
}

function AdaugaMelodiePlaylist($playlistId, $melodieId)
{
    $connection = connectDB();
    $playlistId = mysqli_real_escape_string($connection, $playlistId);
    $melodieId = mysqli_real_escape_string($connection, $melodieId);

    $query = "INSERT INTO melodieplaylist (PlaylistId, MelodieId) VALUES ($playlistId, $melodieId);"; 
    $result = mysqli_query($connection, $query);
    $success = $result !== false;
    closeDatabaseConnection($connection);
    return $success;
}
function StergeMelodie($melodieId)
{
    $connection = connectDB();
    $melodieId = mysqli_real_escape_string($connection, $melodieId);
    $query = "DELETE FROM melodie WHERE MelodieId = $melodieId;";
    $result = mysqli_query($connection, $query);
    $success = $result !== false;
    closeDatabaseConnection($connection);
    return $success;
}
function StergePlaylist($playlistId)
{
    $connection = connectDB();
    $playlistId = mysqli_real_escape_string($connection, $playlistId);
    $query = "DELETE FROM playlist WHERE PlaylistId = $playlistId;";
    $result = mysqli_query($connection, $query);
    $success = $result !== false;
    closeDatabaseConnection($connection);
    return $success;
}
function UpdatePlaylistDenumire($playlistId, $playlistDenumire)
{
    $connection = connectDB();
    $playlistId = mysqli_real_escape_string($connection, $playlistId);
    $playlistDenumire = mysqli_real_escape_string(
        $connection,
        $playlistDenumire
    );
    $query = "UPDATE playlist SET Denumire='$playlistDenumire' WHERE PlaylistId = $playlistId;";
    $result = mysqli_query($connection, $query);
    $success = $result !== false;
    closeDatabaseConnection($connection);
    return $success;
}
function StergeArtist($artistId)
{
    $connection = connectDB();
    $artistId = mysqli_real_escape_string($connection, $artistId);
    $query = "DELETE FROM artist WHERE ArtistId = $artistId";
    $result = mysqli_query($connection, $query);
    $success = $result !== false;
    closeDatabaseConnection($connection);
    return $success;
}
function StergeGenMuzical($genMuzicalId)
{
    $connection = connectDB();
    $genMuzicalId = mysqli_real_escape_string($connection, $genMuzicalId);
    $query = "DELETE FROM genmuzical WHERE GenMuzicalId = $genMuzicalId";
    $result = mysqli_query($connection, $query);
    $success = $result !== false;
    closeDatabaseConnection($connection);
    return $success;
}

function StergeMelodiePlaylist($playlistId, $melodieId)
{
    $connection = connectDB(); 
    $playlistId = mysqli_real_escape_string($connection, $playlistId);
    $melodieId = mysqli_real_escape_string($connection, $melodieId);
    $query = "DELETE FROM melodieplaylist WHERE PlaylistId = $playlistId AND MelodieId=$melodieId";
    $result = mysqli_query($connection, $query);
    $success = $result !== false;
    closeDatabaseConnection($connection);
    return $success;
}
 ?>
