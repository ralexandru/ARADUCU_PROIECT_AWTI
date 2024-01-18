<?php
include "clase.php";
class DatabaseManager
{
    private $conn;

    public function __construct($host, $username, $password, $database)
    {
        $this->conn = new mysqli($host, $username, $password, $database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getAllMelodii()
    {
        $melodii = [];

        $result = $this->conn->query("SELECT * FROM melodie");

        while ($row = $result->fetch_assoc()) {
            $melodie = new Melodie(
                $row["MelodieId"],
                $row["ArtistId"],
                $row["NumeMelodie"],
                $row["GenMuzicalId"],
                $row["Video"],
                $row["MelodiePath"],
                $row["Descriere"],
                $row["VersuriPath"],
                $row["imgPath"]
            );

            $melodii[] = $melodie;
        }

        return $melodii;
    }
    public function getAllMelodiiGen($genMuzicalId)
    {
        $melodii = [];

        $result = $this->conn->query(
            "SELECT * FROM melodie WHERE GenMuzicalId = $genMuzicalId;"
        );

        while ($row = $result->fetch_assoc()) {
            $melodie = new Melodie(
                $row["MelodieId"],
                $row["ArtistId"],
                $row["NumeMelodie"],
                $row["GenMuzicalId"],
                $row["Video"],
                $row["MelodiePath"],
                $row["Descriere"],
                $row["VersuriPath"],
                $row["imgPath"]
            );

            $melodii[] = $melodie;
        }

        return $melodii;
    }

    public function getMelodie($melodieId)
    {
        $melodie;

        $result = $this->conn->query(
            "SELECT * FROM melodie WHERE MelodieId=" . $melodieId
        );

        while ($row = $result->fetch_assoc()) {
            $melodie = new Melodie(
                $row["MelodieId"],
                $row["ArtistId"],
                $row["NumeMelodie"],
                $row["GenMuzicalId"],
                $row["Video"],
                $row["MelodiePath"],
                $row["Descriere"],
                $row["VersuriPath"],
                $row["imgPath"]
            );
        }

        return $melodie;
    }

    public function getPlaylists($numeUtilizator)
    {
        $playlists = [];
        $melodii = [];
        $result = $this->conn->query(
            "SELECT * FROM playlist INNER JOIN utilizatori ON playlist.UtilizatorId = utilizatori.UtilizatorId WHERE utilizatori.NumeUtilizator='" .
                $numeUtilizator .
                "'"
        );
        while ($row = $result->fetch_assoc()) {
            $melodii = [];
            $playlist = new Playlist($row["PlaylistId"], $row["Denumire"]);
            $melodiiPlaylist = $this->conn->query(
                "SELECT DISTINCT mel.MelodieId, ArtistId, NumeMelodie, GenMuzicalId, Video, MelodiePath, Descriere, VersuriPath, imgPath FROM Melodie mel INNER JOIN melodieplaylist melList ON melList.MelodieId=mel.MelodieId INNER JOIN playlist plist ON plist.PlaylistId = melList.PlaylistId INNER JOIN utilizatori us ON us.UtilizatorId = plist.UtilizatorId AND us.NumeUtilizator ='" .
                    $numeUtilizator .
                    "'  AND plist.PlaylistId=" .
                    $playlist->PlaylistId .
                    ""
            );
            while ($melodie = $melodiiPlaylist->fetch_assoc()) {
                $melodiePlist = new Melodie(
                    $melodie["MelodieId"],
                    $melodie["ArtistId"],
                    $melodie["NumeMelodie"],
                    $melodie["GenMuzicalId"],
                    $melodie["Video"],
                    $melodie["MelodiePath"],
                    $melodie["Descriere"],
                    $melodie["VersuriPath"],
                    $melodie["imgPath"]
                );
                $melodii[] = $melodie;
            }
            $playlist->melodii = $melodii;
            $playlists[] = $playlist;
        }
        return $playlists;
    }

    public function getPlaylist($playlistId)
    {
        $playlists = [];

        $result = $this->conn->query(
            "SELECT * FROM playlist WHERE PlaylistId=" . $playlistId
        );
        while ($row = $result->fetch_assoc()) {
            $playlist = new Playlist($row["PlaylistId"], $row["Denumire"]);
            $melodii = null;
            $melodiiPlaylist = $this->conn->query(
                "SELECT DISTINCT * FROM Melodie mel INNER JOIN melodieplaylist melList ON melList.MelodieId=mel.MelodieId WHERE melList.PlaylistId=" .
                    $playlistId
            );
            while ($melodie = $melodiiPlaylist->fetch_assoc()) {
                $melodiePlist = new Melodie(
                    $melodie["MelodieId"],
                    $melodie["ArtistId"],
                    $melodie["NumeMelodie"],
                    $melodie["GenMuzicalId"],
                    $melodie["Video"],
                    $melodie["MelodiePath"],
                    $melodie["Descriere"],
                    $melodie["VersuriPath"],
                    $melodie["imgPath"]
                );
                $melodii[] = $melodie;
            }
            if ($melodii != null) {
                $playlist->melodii = $melodii;
            }
            $playlists[] = $playlist;
        }
        return $playlists;
    }

    public function getAllArtisti()
    {
        $artisti = [];

        $result = $this->conn->query("SELECT * FROM artist");

        while ($row = $result->fetch_assoc()) {
            $artist = new Artisti(
                $row["ArtistId"],
                $row["Nume"],
                $row["Prenume"]
            );

            $artisti[] = $artist;
        }

        return $artisti;
    }

    public function getAllGenuriMuzicale()
    {
        $genuriMuzicale = [];

        $result = $this->conn->query("SELECT * FROM genmuzical");

        while ($row = $result->fetch_assoc()) {
            $genMuzical = new GenMuzical(
                $row["GenMuzicalId"],
                $row["Denumire"]
            );

            $genuriMuzicale[] = $genMuzical;
        }

        return $genuriMuzicale;
    }
}
?>
