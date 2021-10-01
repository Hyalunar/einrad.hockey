<?php

class Archiv_Turnier {
    
    private int $turnier_id;
    private int $saison;
    private int $spieltag;
    private string $datum;
    private int $plaetze;
    private string $tblock;
    private string $art;
    private ?string $tname;
    private string $hallenname;
    private string $startzeit;
    private string $ausrichter;
    private string $ort;
    private string $format;

    private array $ergebnisse;
    private array $teams;
    private array $spiele;
        
    
    public function __construct()
    {
        $this->ergebnisse = $this->set_ergebnisse();
        $this->teams = $this->set_teams();
        $this->spiele = $this->set_spiele();
    }

    /**
     * Getter als "Constructor"
     */
    public static function get($turnier_id): Archiv_Turnier
    {
        $sql = "
            SELECT * 
            FROM archiv_turniere_liga
            LEFT JOIN archiv_turniere_details ON archiv_turniere_liga.turnier_id = archiv_turniere_details.turnier_id
            WHERE archiv_turniere_liga.turnier_id = ?
        ";

        return db::$archiv->query($sql, $turnier_id)->fetch_object(__CLASS__) ?? new Archiv_Turnier();
    }

    /**
     * Zeigt das Turnier
     */
    public function show()
    {
        include '../../templates/ergebnis.tmp.php';
    }

    /**
     * Setzt die Turnierergebnisse
     * 
     * @return array
     */
    
    public function set_ergebnisse(): array
    {
        $sql = "
            SELECT * 
            FROM archiv_turniere_ergebnisse
            LEFT JOIN archiv_teams_liga ON archiv_teams_liga.team_id = archiv_turniere_ergebnisse.team_id
            WHERE turnier_id = ?
            ORDER BY platz ASC
            ";

        $ergebnisse = db::$archiv->query($sql, $this->turnier_id)->esc()->fetch();

        return $ergebnisse;
    }

    /**
     * Setzt die teilnehmenden Teams
     * 
     * @return array
     */
    public function set_teams(): array
    {
        $sql = "
            SELECT * 
            FROM archiv_turniere_ergebnisse
            LEFT JOIN archiv_teams_liga ON archiv_teams_liga.team_id = archiv_turniere_ergebnisse.team_id
            WHERE turnier_id = ?
        ";

        $teams = db::$archiv->query($sql, $this->turnier_id)->esc()->fetch();

        return $teams;
    }

    /**
     * Setzt die Turnier-Spiele
     * 
     * @return array
     */
    public function set_spiele()
    {
        $sql = "
            SELECT *
            FROM archiv_turniere_spiele
            WHERE turnier_id = ?
        ";

        $spiele = db::$archiv->query($sql, $this->turnier_id)->esc()->fetch();

        return $spiele;
    }

    /**
     * Gibt die turnier_id
     * 
     * @return int
     */
    public function get_turnier_id(): int
    {
        return $this->turnier_id;
    }

    /**
     * Gibt die Saison
     * 
     * @return int
     */
    public function get_saison(): int
    {
        return $this->saison;
    }

    /**
     * Gibt den Spieltag
     * 
     * @return int
     */
    public function get_spieltag(): int
    {
        return $this->spieltag;
    }

    /**
     * Gibt das Datum
     * 
     * @return string
     */
    public function get_datum(): string
    {
        return $this->datum;
    }

    /**
     * Gibt die Plätze
     * 
     * @return int
     */
    public function get_plaetze(): int
    {
        return $this->plaetze;
    }

    /**
     * Gibt den Turnier-Block
     * 
     * @return string
     */
    public function get_tblock(): string
    {
        return $this->tblock;
    }

    /**
     * Gibt die Turnier-Art
     * 
     * @return string
     */
    public function get_art(): string
    {
        return $this->art;
    }

    /**
     * Gibt den Turniernamen
     * 
     * @return string|null
     */
    public function get_tname(): string|null
    {
        return $this->tname;
    }

    /**
     * Gibt den Hallennamen
     * 
     * @return string
     */
    public function get_hallenname(): string
    {
        return $this->hallenname;
    }

    /**
     * Gibt die Startzeit
     * 
     * @return string
     */
    public function get_startzeit(): string
    {
        return $this->startzeit;
    }

    /**
     * Gibt den Ausrichter
     * 
     * @return int
     */
    public function get_ausrichter(): int
    {
        return $this->ausrichter;
    }

    /**
     * Gibt den Turnier-Ort
     * 
     * @return string
     */
    public function get_ort(): string
    {
        return $this->ort;
    }

    /**
     * Gibt das Turnier-Format
     * 
     * @return string
     */
    public function get_format(): string
    {
        return $this->format;
    }

    /**
     * Gibt die Ergebnisse
     * 
     * @return array
     */
    public function get_ergebnisse(): array
    {
        return $this->ergebnisse;
    }

    /**
     * Gibt die Teams
     * 
     * @return array
     */
    public function get_teams(): array
    {
        return $this->teams;
    }

    /**
     * Gibt die Spiele
     * 
     * @return array
     */
    public function get_spiele(): array
    {
        return $this->spiele;
    }
}