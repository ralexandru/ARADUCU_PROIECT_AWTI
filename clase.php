<?php
class Melodie
{
    public $MelodieId;
    public $ArtistId;
    public $NumeMelodie;
    public $GenMuzicalId;
    public $Video;
    public $MelodiePath;
    public $Descriere;
    public $VersuriPath;
    public $imgPath;

    public function __construct(
        $MelodieId,
        $ArtistId,
        $NumeMelodie,
        $GenMuzicalId,
        $Video,
        $MelodiePath,
        $Descriere,
        $VersuriPath,
        $imgPath
    ) {
        $this->MelodieId = $MelodieId;
        $this->NumeMelodie = $NumeMelodie;
        $this->ArtistId = $ArtistId;
        $this->GenMuzicalId = $GenMuzicalId;
        $this->Video = $Video;
        $this->MelodiePath = $MelodiePath;
        $this->Descriere = $Descriere;
        $this->VersuriPath = $VersuriPath;
        $this->imgPath = $imgPath;
    }
}

class Artisti
{
    public $ArtistId;
    public $ArtistNume;
    public $ArtistPrenume;

    public function __construct($ArtistId, $ArtistNume, $ArtistPrenume)
    {
        $this->ArtistId = $ArtistId;
        $this->ArtistNume = $ArtistNume;
        $this->ArtistPrenume = $ArtistPrenume;
    }

    public function GetNumePrenume()
    {
        return $this->ArtistNume . " " . $this->ArtistPrenume;
    }
}

class GenMuzical
{
    public $GenMuzicalId;
    public $Denumire;

    public function __construct($GenMuzicalId, $Denumire)
    {
        $this->GenMuzicalId = $GenMuzicalId;
        $this->Denumire = $Denumire;
    }
}

class Playlist
{
    public $PlaylistId;
    public $Denumire;
    public $melodii;

    public function __construct($PlaylistId, $Denumire)
    {
        $this->PlaylistId = $PlaylistId;
        $this->Denumire = $Denumire;
        $this->melodii = [];
    }
}

class Utilizator
{
    public $UtilizatorId;
    public $NumeUtilizator;
    public $AdresaMail;
    public $nivelAcces;

    public function __construct(
        $UtilizatorId,
        $NumeUtilizator,
        $AdresaMail,
        $nivelAcces
    ) {
        $this->UtilizatorId = $UtilizatorId;
        $this->NumeUtilizator = $NumeUtilizator;
        $this->AdresaMail = $AdresaMail;
        $this->nivelAcces = $nivelAcces;
    }
}
?>

