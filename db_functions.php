<?php

// Creaza conexiune
function registerUtilizator(
    $nume,
    $parolaUser,
    $dataNasterii,
    $tara,
    $adresaMail,
    $siteWeb,
    $nrTelefon
) {
    $server = "localhost";
    $utilizator = "root";
    $parola = "";
    $db = "proiect_awti";
    $conn = new mysqli($server, $utilizator, $parola, $db);
    // Verifica
    if ($conn->connect_error) {
        die("Conexiune esuata: " . $conn->connect_error);
    }

    // Pregateste SQL query
    $stmt = $conn->prepare(
        "INSERT INTO utilizatori (NumeUtilizator, Parola, DataNastere, Tara, AdresaMail, SiteWeb, NrTelefon) VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "sssssss",
        $nume,
        $parolaUser,
        $dataNasterii,
        $tara,
        $adresaMail,
        $siteWeb,
        $nrTelefon
    );

    // Executa query
    $stmt->execute();

    // Inchide conexiunea
    $stmt->close();
    $conn->close();
}

function loginUtilizator($numeUtilizator, $parolaUser)
{
    $server = "localhost";
    $utilizator = "root";
    $parola = "";
    $db = "proiect_awti";

    $conn = new mysqli($server, $utilizator, $parola, $db);

    if ($conn->connect_error) {
        die("Conexiune esuata: " . $conn->connect_error);
    }

    $stmt = $conn->prepare(
        "SELECT UtilizatorId, NumeUtilizator, AdresaMail, Parola, nivelAcces FROM Utilizatori WHERE NumeUtilizator = ? AND parola = ?"
    );
    $stmt->bind_param("ss", $numeUtilizator, $parolaUser);

    // Executa statementul
    $stmt->execute();

    // Variabilele rezultate
    $stmt->bind_result(
        $utilizatorId,
        $numeUtilizatorDB,
        $adresaMail,
        $parolaDB,
        $nivelAcces
    );

    // Preiau rezultatul
    $stmt->fetch();

    $utilizatorDB = new Utilizator(
        $utilizatorId,
        $numeUtilizatorDB,
        $adresaMail,
        $nivelAcces
    );
    $stmt->close();
    $conn->close();

    return $utilizatorDB;
}

function verificaUtilizator($numeUtilizator)
{
    $server = "localhost";
    $utilizator = "root";
    $parola = "";
    $db = "proiect_awti";

    $conn = new mysqli($server, $utilizator, $parola, $db);

    if ($conn->connect_error) {
        die("Conexiune esuata: " . $conn->connect_error);
    }

    $stmt = $conn->prepare(
        "SELECT COUNT(UtilizatorId) FROM Utilizatori WHERE NumeUtilizator = ?"
    );
    $stmt->bind_param("s", $numeUtilizator);

    $stmt->execute();

    $stmt->bind_result($utilizatoriCuAcestNume);

    $stmt->fetch();
    $loginSuccessful = $utilizatoriCuAcestNume == 0;

    $stmt->close();
    $conn->close();

    return $loginSuccessful;
}
?>

