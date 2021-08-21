<?php

/**
 * Class Team
 * Alle Funktionen zum Darstellen und Verwalten von Teamdaten
 */
class nTeam
{
    /**
     * TeamID zur eindeutigen Identifikation
     * @var int
     */
    public int $team_id;
    public ?string $teamname;
    public ?string $ligateam;
    public ?string $passwort;
    public ?string $passwort_geaendert;
    public ?string $freilose;
    public ?string $zweites_freilos;
    public ?string $aktiv;

    public ?int $plz;
    public ?string $ort;
    public ?string $verein;
    public ?string $homepage;
    public ?string $ligavertreter;
    public ?string $teamfoto;
    public ?string $trikot_farbe_1;
    public ?string $trikot_farbe_2;

    /**
     * @return bool
     */
    public function check_ligateam(): bool
    {
        return $this->ligateam === 'Ja';
    }

    /**
     * @param string $ligateam
     */
    public function set_ligateam(string $ligateam): void
    {
        $this->ligateam = $ligateam;
    }

    /**
     * @return string|null
     */
    public function get_passwort(): ?string
    {
        return $this->passwort;
    }

    /**
     * @param string|null $passwort
     * @return nTeam
     */
    public function set_passwort(?string $passwort): nTeam
    {
        // Passwort hashen
        $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);
        if (!is_string($passwort)) {
            trigger_error("set_passwort fehlgeschlagen.", E_USER_ERROR);
        }
        $this->passwort = $passwort_hash;

        $this->set_passwort_geaendert(Helper::$teamcenter ? 'Ja' : 'Nein');

        return $this;
    }

    /**
     * @return string|null
     */
    public function get_freilose(): ?string
    {
        return $this->freilose;
    }

    /**
     * @param string|null $freilose
     */
    public function set_freilose(?string $freilose): void
    {
        $this->freilose = $freilose;
    }

    /**
     */
    public function add_freilos(): void
    {
        ++$this->freilose;
    }

    /**
     * @return string|null
     */
    public function get_zweites_freilos(): ?string
    {
        return $this->zweites_freilos;
    }

    /**
     */
    public function set_zweites_freilos(): void
    {

        $this->zweites_freilos = date("Y-m-d h:i:s");
    }

    private bool $error;

    /**
     * @return string
     */
    public function get_teamname(): string
    {
        return db::escape($this->teamname);
    }

    /**
     * @param string $teamname
     * @return nTeam
     */
    public function set_teamname(string $teamname): nTeam
    {
        $sql = "
                SELECT teamname 
                FROM teams_liga
                WHERE teamname = ?
                ";

        if (db::$db->query($sql, $teamname)->affected_rows() > 0){
            Html::error("Der Teamname existiert schon.");
            $this->error = true;
            return $this;
        }

        $this->teamname = $teamname;
        return $this;

    }

    /**
     * @return string
     */
    public function check_passwort_geaendert(): string
    {
        return $this->passwort_geaendert === "Ja";
    }

    /**
     * @param string $passwort_geaendert
     */
    public function set_passwort_geaendert(string $passwort_geaendert): void
    {
        $this->passwort_geaendert = $passwort_geaendert;
    }

    /**
     * @return bool
     */
    public function check_aktiv(): bool
    {
        return $this->aktiv === 'Ja';
    }

    /**
     * @param string $aktiv
     */
    public function set_aktiv(string $aktiv): void
    {
        $this->aktiv = $aktiv;
    }

    /**
     * @return int|null
     */
    public function get_plz(): ?int
    {
        return $this->plz;
    }

    /**
     * @param int|null $plz
     * @return nTeam
     */
    public function set_plz(?int $plz): nTeam
    {
        $this->plz = $plz;
        return $this;
    }

    /**
     * @return string|null
     */
    public function get_ort(): ?string
    {
        return db::escape($this->ort);
    }

    /**
     * @param string|null $ort
     * @return nTeam
     */
    public function set_ort(?string $ort): nTeam
    {
        $this->ort = $ort;
        return $this;
    }

    /**
     * @return string|null
     */
    public function get_verein(): ?string
    {
        return db::escape($this->verein);
    }

    /**
     * @param string|null $verein
     */
    public function set_verein(?string $verein): void
    {
        $this->verein = $verein;
    }

    /**
     * @return string|null
     */
    public function get_homepage(): ?string
    {
        return db::escape($this->homepage);
    }

    /**
     * @param string|null $homepage
     * @return nTeam
     */
    public function set_homepage(?string $homepage): nTeam
    {
        if (filter_var($homepage, FILTER_VALIDATE_URL)) {
            $this->homepage = $homepage;
        } else {
            Html::error("Ungültige Webadresse. Sie muss mit http:// oder https:// beginnen.");
            $this->error = true;
        }
        return $this;

    }

    /**
     * @return string|null
     */
    public function get_ligavertreter(): ?string
    {
        return db::escape($this->ligavertreter);
    }

    /**
     * @param string|null $ligavertreter
     */
    public function set_ligavertreter(?string $ligavertreter): nTeam
    {
        $this->ligavertreter = $ligavertreter;
        return $this;
    }

    /**
     * @return string|null
     */
    public function get_teamfoto(): ?string
    {
        return db::escape($this->teamfoto);
    }

    /**
     * @param string|null $teamfoto
     * @return nTeam
     */
    public function set_teamfoto(?string $teamfoto): nTeam
    {
        $this->teamfoto = $teamfoto;
        return $this;
    }

    /**
     * @return string|null
     */
    public function get_trikot_farbe_1(): ?string
    {
        return db::escape($this->trikot_farbe_1);
    }

    /**
     * @param string|null $trikot_farbe_1
     * @return nTeam
     */
    public function set_trikot_farbe_1(?string $trikot_farbe_1): nTeam
    {
        $this->trikot_farbe_1 = $trikot_farbe_1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function get_trikot_farbe_2(): ?string
    {
        return db::escape($this->trikot_farbe_2);
    }

    /**
     * @param string|null $trikot_farbe_2
     * @return nTeam
     */
    public function set_trikot_farbe_2(?string $trikot_farbe_2): nTeam
    {
        $this->trikot_farbe_2 = $trikot_farbe_2;
        return $this;
    }

    /**
     * Team constructor.
     */
    public function __construct()
    {
    }

    public static function get(int $team_id): object
    {
        $sql = "
                SELECT *  
                FROM teams_liga 
                INNER JOIN teams_details
                ON teams_details.team_id = teams_liga.team_id
                WHERE teams_liga.team_id = ?
                ";
        return db::$db->query($sql, $team_id)->fetch_object(__CLASS__);
    }

    public static function get_deaktiv(): object
    {
        $sql = "
                SELECT *  
                FROM teams_liga 
                INNER JOIN teams_details
                ON teams_details.team_id = teams_liga.team_id
                WHERE teams_liga.aktiv = 'Nein'
                ";
        return db::$db->query($sql)->fetch_object(__CLASS__);
    }

    public static function get_aktiv(int $team_id): object
    {
        $sql = "
                SELECT *  
                FROM teams_liga 
                INNER JOIN teams_details
                ON teams_details.team_id = teams_liga.team_id
                WHERE teams_liga.aktiv = 'Ja'
                ";
        return db::$db->query($sql)->fetch_object(__CLASS__);
    }

    public function get_kader(int $saison = Config::SAISON): array
    {
        return nSpieler::get_kader($this->team_id, $saison); //TODO: Funktion hierein!
    }

    public function speichern($new = false): void
    {
        if ($this->error) {
            Html::error("Team konnte nicht gespeichert werden.");
            return;
        }
        if ($new) {

            $sql = "INSERT INTO teams_liga VALUES ()";
            db::$db->query($sql)->log();

            $team_id = db::$db->get_last_insert_id();
            $this->team_id = $team_id;

            $sql = "INSERT INTO teams_details (team_id) VALUES (?)";
            db::$db->query($sql, $team_id)->log();

        }

        $sql = "
                UPDATE teams_liga 
                SET teamname = ?,
                    ligateam = ?,
                    passwort = ?,
                    passwort_geaendert = ?,
                    freilose = ?,
                    zweites_freilos = ?,
                    aktiv = ?
                WHERE team_id = ?
                ";
        $params = [
            $this->teamname,
            $this->ligateam,
            $this->passwort,
            $this->passwort_geaendert,
            $this->freilose,
            $this->zweites_freilos,
            $this->aktiv
        ];

        db::$db->query($sql, $params)->log();

        $sql = "
                UPDATE teams_details 
                SET plz = ?,
                    ort = ?,
                    verein = ?,
                    homepage = ?,
                    ligavertreter = ?,
                    teamfoto = ?,
                    trikot_farbe_1 = ?,
                    trikot_farbe_2 = ?
                WHERE team_id = ?
                ";
        $params = [
            $this->plz,
            $this->ort,
            $this->verein,
            $this->homepage,
            $this->ligavertreter ,
            $this->teamfoto,
            $this->trikot_farbe_1,
            $this->trikot_farbe_2
        ];

        db::$db->query($sql, $params)->log();
    }
}