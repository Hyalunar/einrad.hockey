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
    public int $id;
    public ?string $teamname;
    public ?string $ligateam;
    public ?string $passwort;
    public ?string $passwort_geaendert;
    public int $freilose;
    public ?string $schiri_freilos;
    public ?string $aktiv;

    public ?int $plz;
    public ?string $ort;
    public ?string $verein;
    public ?string $homepage;
    public ?string $ligavertreter;
    public ?string $teamfoto;
    public ?string $trikot_farbe_1;
    public ?string $trikot_farbe_2;

    private bool $error = false;

    /**
     * @return bool
     */
    public function is_ligateam(): bool
    {
        return $this->ligateam === 'Ja';
    }

    /**
     * @return bool
     */
    public function is_aktiv(): bool
    {
        return $this->aktiv === 'Ja';
    }

    /**
     * @return bool
     */
    public function schiri_freilos_erhalten(): bool
    {
        $erhalten_am = empty($this->schiri_freilos)
            ? 0
            : strtotime($this->schiri_freilos);
        return $erhalten_am >= strtotime(Config::SAISON_ANFANG);
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
     * @param String $passwort
     * @return bool
     */
    public function is_correct_passwort(String $passwort): bool
    {
        return password_verify($passwort, $this->passwort);
    }

    /**
     * @return string|null
     */
    public function get_freilose(): ?string
    {
        return $this->freilose;
    }

    /**
     * @param int $freilose
     */
    public function set_freilose(int $freilose): void
    {
        $this->freilose = $freilose;
    }

    /**
     */
    public function add_freilos(): void
    {
        $this->freilose++;
    }

    /**
     * @return string|null
     */
    public function get_schiri_freilos(): ?string
    {
        return $this->schiri_freilos;
    }

    /**
     */
    public function set_schiri_freilos(): void // TODO CHECKS EINBAUEN
    {
        $this->schiri_freilos = date("Y-m-d h:i:s");
    }


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
     * @param int $plz
     * @return nTeam
     */
    public function set_plz(int $plz): nTeam
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
     * @param string $ligavertreter
     * @return nTeam
     */
    public function set_ligavertreter(string $ligavertreter): nTeam
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

    public function is_teamfoto(): bool
    {
        if (file_exists($this->teamfoto)) {
            return true;
        }

        if (!empty($this->teamfoto)) {
            trigger_error("Teamfoto wurde nicht gefunden.");
        }

        return false;
    }

    /**
     * @param string|null $teamfoto
     * @return nTeam
     */
    public function set_teamfoto(?string $teamfoto): nTeam  //TODO Checks einbauen, hochladen?
    {
        $this->teamfoto = $teamfoto;
        return $this;
    }

    /**
     * @param int $kit
     * @return string|null
     */
    public function get_trikot_farbe(int $kit): ?string
    {
        $trikot_farbe = "trikot_farbe_" . $kit;
        return db::escape($this->$trikot_farbe);
    }

    /**
     * @param int $kit
     * @return string|null
     */
    public function check_trikot_farbe(int $kit): ?string
    {

        $trikot_farbe = "trikot_farbe_" . $kit;

        if (empty($this->$trikot_farbe)) {
            return true;
        }

        return !preg_match('/^#[a-f0-9]{6}$/i', $this->$trikot_farbe);
    }

    /**
     * @param int $kit
     * @param string|null $farbe
     * @return nTeam
     */
    public function set_trikot_farbe(int $kit, ?string $farbe): nTeam
    {
        $trikot_farbe = "trikot_farbe_" . $kit;
        $this->$trikot_farbe = $farbe;

        if (!$this->check_trikot_farbe($kit)) {
            $this->error = true;
            Html::error("Es wurde eine ugültige Farbe übermittelt.");
        }

        return $this;
    }

    /**
     * Team constructor.
     */
    public function __construct(){
        $this->id = $this->team_id ?? null;
    }

    public static function get(int $team_id): nTeam
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
        return db::$db->query($sql)->fetch_objects(__CLASS__, "team_id");
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
        return db::$db->query($sql)->fetch_objects(__CLASS__, "team_id");
    }

    public function get_kader(int $saison = Config::SAISON): array
    {
        return nSpieler::get_kader($this->team_id, $saison); //TODO: Funktion hierein!
    }

    public function insert_to_db() {

        if ($this->error) {
            Html::error("Team konnte nicht eingetragen werden.");
            return;
        }

        $sql = "INSERT INTO teams_liga VALUES ()";
        db::$db->query($sql)->log();

        $team_id = db::$db->get_last_insert_id();
        $this->team_id = $team_id;

        $sql = "INSERT INTO teams_details (team_id) VALUES (?)";
        db::$db->query($sql, $team_id)->log();

        $this->speichern(); //TODO Dies ebenfalls in nSpieler so übernehmen

    }

    public function speichern(): void
    {
        if ($this->error) {
            Html::error("Team konnte nicht gespeichert werden.");
            return;
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
            $this->schiri_freilos,
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

    /**
     * @return string
     */
    public function get_link_teamdaten_aendern(): string
    {

        if (Helper::$ligacenter) {
            return Env::BASE_URL . "/ligacenter/lc_teamdaten_aendern.php?team_id=" . $this->team_id;
        }

        return Env::BASE_URL . "/teamcenter/tc_teamdaten_aendern.php?team_id=" . $this->team_id;

    }

}