<?php

class Archiv_Saison {

    private int $saison_id;
    private string $saison_string;
    
    private int $anz_ligateams;
    private int $anz_ligaturniere;
    private ?int $meister;
    private ?int $afinale;
    private ?int $quali;
    private ?int $bfinale;
    private ?int $cfinale;
    private ?int $dfinale;

    public function __construct(int $saison_id)
    {
        $this->saison_id = $saison_id;

        $this->saison_string = $this->set_saison_string();
        $this->anz_ligateams = $this->set_anz_ligateams();
        $this->anz_ligaturniere = $this->set_anz_ligaturniere();
        $this->meister = $this->set_meister();
        $this->afinale = $this->set_afinale();
        $this->quali = $this->set_quali();
        $this->bfinale = $this->set_bfinale();
        $this->cfinale = $this->set_cfinale();
        $this->dfinale = $this->set_dfinale();
    }
        
    /**
     * Setzt die Anzahl der LIGATURNIER
     * 
     * @return int
     */
    public function set_anz_ligaturniere(): int
    {
        $sql = "
            SELECT COUNT(*) as anz_turniere
            FROM archiv_turniere_liga
            WHERE saison = ?
            AND tblock NOT LIKE '%FINALE' 
            AND tblock NOT LIKE 'QUALI'
        ";

        $anz_turniere = db::$archiv->query($sql, $this->saison_id)->esc()->fetch_one();

        return $anz_turniere ?? 0;
    }

    /**
     * Setzt die Anzahl der LIGATEAMS
     * 
     * @return int
     */
    public function set_anz_ligateams(): int
    {
        $sql = "
            SELECT COUNT(*) as anz_teams
            FROM archiv_teams_liga
            WHERE saison = ?
            AND ligateam = 'Ja'";

        $anz_teams = db::$archiv->query($sql, $this->saison_id)->esc()->fetch_one();

        return $anz_teams ?? 0;
    }

    /**
     * Setzt den Meister
     * 
     * @return int|null
     */
    public function set_meister(): int|null
    {
        $sql = "
            SELECT archiv_turniere_ergebnisse.team_id
            FROM archiv_turniere_liga
            LEFT JOIN archiv_turniere_ergebnisse ON archiv_turniere_liga.turnier_id = archiv_turniere_ergebnisse.turnier_id
            WHERE archiv_turniere_liga.tblock = 'AFINALE'
            AND archiv_turniere_liga.saison = ?
            AND archiv_turniere_ergebnisse.platz = 1
            ";
        
        $team_id = db::$archiv->query($sql, $this->saison_id)->esc()->fetch_one();

        return $team_id;
    }

    /**
     * Setzt das AFINALE
     * 
     * @return null|int
     */
    public function set_afinale(): null|int
    {    
        $sql = "
            SELECT turnier_id
            FROM archiv_turniere_liga
            WHERE tblock = 'AFINALE'
            AND saison = ?
            ";
        $result = db::$archiv->query($sql, $this->saison_id)->esc()->fetch_one();

        if (empty($result)) {
            return null;
        }
        
        return $result;
    }

    /**
     * Setzt das QUALI
     * 
     * @return null|int
     */
    public function set_quali(): null|int
    {
        $sql = "
            SELECT turnier_id
            FROM archiv_turniere_liga
            WHERE tblock = 'QUALI'
            AND saison = ?
            ";
        $result = db::$archiv->query($sql, $this->saison_id)->esc()->fetch_one();
        
        if (empty($result)) {
            return null;
        }
        
        return $result;
    }

    /**
     * Setzt das BFINALE
     * 
     * @return null|int
     */
    public function set_bfinale(): null|int
    {
        $sql = "
            SELECT turnier_id
            FROM archiv_turniere_liga
            WHERE tblock = 'BFINALE'
            AND saison = ?
            ";
        $result = db::$archiv->query($sql, $this->saison_id)->esc()->fetch_one();
        
        if (empty($result)) {
            return null;
        }
        
        return $result;
    }

    /**
     * Setzt das CFINALE
     * 
     * @return null|int
     */
    public function set_cfinale(): null|int
    {
        $sql = "
            SELECT turnier_id
            FROM archiv_turniere_liga
            WHERE tblock = 'CFINALE'
            AND saison = ?
            ";
        $result = db::$archiv->query($sql, $this->saison_id)->esc()->fetch_one();
        
        if (empty($result)) {
            return null;
        }
        
        return $result;
    }

    /**
     * Setzt das DFINALE
     * 
     * @return null|int
     */
    public function set_dfinale(): null|int
    {
        $sql = "
            SELECT turnier_id
            FROM archiv_turniere_liga
            WHERE tblock = 'DFINALE'
            AND saison = ?
            ";
        $result = db::$archiv->query($sql, $this->saison_id)->esc()->fetch_one();
        
        if (empty($result)) {
            return null;
        }
        
        return $result;
    }

    /**
     * Setzt den Saison-String
     * 
     * @return string
     */
    public function set_saison_string(): string
    {
        return Html::get_saison_string($this->saison_id);
    }

    /**
     * Gibt die saison_id
     * 
     * @return int
     */
    public function get_saison_id(): int
    {
        return $this->saison_id;
    }
    
    /**
     * Gibt den Saison-String
     * 
     * @return string
     */
    public function get_saison_string(): string
    {
        return $this->saison_string;
    }

    /**
     * Gibt die Anzahl der LIGATEAMS
     * 
     * @return int
     */
    public function get_anz_ligateams(): int
    {
        return $this->anz_ligateams;
    }

    /**
     * Gibt die Anzahl der LIGATURNIERE
     * 
     * @return int
     */
    public function get_anz_ligaturniere(): int
    {
        return $this->anz_ligaturniere;
    }

    /**
     * Gibt den Meister zurück
     * 
     * @return null|string
     */
    public function get_meister(): null|string
    {
        return $this->meister;
    }

    /**
     * Gibt die A-Meisterschaft
     * 
     * @return null|null|int
     */
    public function get_afinale(): null|int
    {
        return $this->afinale;
    }

    /**
     * Gibt die Qualifikation
     * 
     * @return null|null|int
     */
    public function get_quali(): null|int
    {
        return $this->quali;
    }

    /**
     * Gibt die B-Meisterschaft
     * 
     * @return null|null|int
     */
    public function get_bfinale(): null|int
    {
        return $this->bfinale;
    }

    /**
     * Gibt die C-Meisterschaft
     * 
     * @return null|null|int
     */
    public function get_cfinale(): null|int
    {
        return $this->cfinale;
    }

    /**
     * Gibt die D-Meisterschaft
     * 
     * @return null|null|int
     */
    public function get_dfinale(): null|int
    {
        return $this->dfinale;
    }
    
    /**
     * Gibt eine Liste der LIGATURNIERE der Saison zurück
     * @param int $saison
     * 
     * @return Archiv_Turniere[]
     */
    public function get_liste_ligaturniere(): array
    {
        $sql = "
            SELECT *
            FROM archiv_turniere_liga
            LEFT JOIN archiv_turniere_details ON archiv_turniere_details.turnier_id = archiv_turniere_liga.turnier_id
            WHERE saison = ?
            AND art != 'spass'
            AND art != 'final'
            ORDER BY datum ASC
        ";

        return db::$archiv->query($sql, $this->saison_id)->fetch_objects('Archiv_Turnier', key: 'turnier_id');
    }

    /**
     * Gibt eine Liste der ABSCHLUSSTURNIERE der Saison zurück
     * @param int $saison
     * 
     * @return Archiv_Turniere[]
     */
    
    public function get_liste_abschlussturniere(): array
    {
        $sql = "
            SELECT *
            FROM archiv_turniere_liga
            LEFT JOIN archiv_turniere_details ON archiv_turniere_details.turnier_id = archiv_turniere_liga.turnier_id
            WHERE saison = ?
            AND art = 'final'
            ORDER BY FIELD(tblock, 'AFINALE', 'QUALI', 'BFINALE', 'CFINALE', 'DFINALE');
        ";

        $result = db::$archiv->query($sql, $this->saison_id)->fetch_objects('Archiv_Turnier', key: 'turnier_id');

        return $result;
    }

    /**
     * Gibt die Platzierung eines Teams in der Rangtabelle zurück
     *
     * @param int $team_id
     * @param int|null $spieltag
     * @return int|null
     */
    public static function get_team_rang(int $team_id, int $spieltag = NULL): ?int
    {
        return $rangtabelle[$spieltag][$team_id]['rang'] ?? NULL;
    }

    /**
     * Weist dem Platz in der Rangtabelle eine Wertung zu
     *
     * @param int|null $rang
     * @return int|null
     */
    public function rang_to_wertigkeit(?int $rang): ?int
    {
        // Nichtligateam
        if (is_null($rang)){
            return NULL;
        }

        if ($this->saison_id >= 22) {
            // Platz 1 bis 43;
            if (1 <= $rang && 43 >= $rang){
                return round(250 * 0.955 ** ($rang - 1));
            }

            // Platz 44 bis Rest
            return max([round(250 * 0.955 ** (43) * 0.97 ** ($rang - 1 - 43)), 15]);
        } elseif ($this->saison_id >= 20) {
            if (1 <= $rang && 13 >= $rang) {
                return round(200 - (($rang - 1) * 8));
            } 
            if (14 <= $rang && 25 >= $rang) {
                return round(104 - (($rang - 13) * 4));
            }
            if (26 <= $rang && 37 >= $rang) {
                return round(56 - (($rang - 25) * 2));
            }
            return max([round(31 - ($rang - 38)), 20]);
        } elseif ($this->saison_id >= 16) {
            if (1 <= $rang && 8 >= $rang) {
                return round(150 - (($rang - 1) * 2));
            } 
            if (9 <= $rang && 16 >= $rang) {
                return round(118 - (($rang - 9) * 2));
            }
            if (17 <= $rang && 24 >= $rang) {
                return round(90 - (($rang - 17) * 2));
            }
            if (25 <= $rang && 32 >= $rang) {
                return round(66 - (($rang - 25) * 2));
            }
            return max([round(46 - (($rang - 33) * 2)), 6]);
        } elseif ($this->saison_id >= 13) {
            if (1 <= $rang && 6 >= $rang) {
                return round(134 - (($rang - 1) * 2));
            } 
            if (7 <= $rang && 12 >= $rang) {
                return round(114 - (($rang - 7) * 2));
            }
            if (13 <= $rang && 18 >= $rang) {
                return round(96 - (($rang - 13) * 2));
            }
            if (19 <= $rang && 24 >= $rang) {
                return round(66 - (($rang - 19) * 2));
            }
            return max([round(46 - (($rang - 25) * 2)), 2]);
        } elseif ($this->saison_id >= 8) {
            return max([round(132 - (($rang - 1) * 2)), 20]);
        }

        return NULL;
    }

    /**
     * Weist dem Platz in der Rangtabelle einen Block zu
     *
     * @param int|null $rang
     * @return string|null
     */
    public function rang_to_block(?int $rang): ?string
    {
        $zuordnung = $this->get_block_zuordnung($this->saison_id);
        
        // Nichtligateam
        if (is_null($rang)) return NULL;

        // Blockzuordnung
        foreach ($zuordnung as $block => $range) {
            if ($range[0] <= $rang && $range[1] >= $rang){
                return $block;
            }
        }
    }

    public function get_block_zuordnung()
    {
        if ($this->saison_id >= 22) {
            $zuordnung = [
                "A" => [1, 6],
                "AB" => [7, 13],
                "BC" => [14, 21],
                "CD" => [22, 31],
                "DE" => [32, 43],
                "EF" => [44, 57],
                "F" => [58, INF]
            ];
        } elseif ($this->saison_id >= 20) {
            $zuordnung = [
                "A" => [1, 6],
                "AB" => [7, 12],
                "BC" => [13, 18],
                "CD" => [19, 24],
                "DE" => [25, 30],
                "EF" => [31, 36],
                "F" => [37, INF]
            ];
        } elseif ($this->saison_id >= 16) {
            $zuordnung = [
                "A" => [1, 8],
                "AB" => [9, 16],
                "BC" => [17, 24],
                "CD" => [25, 32],
                "DE" => [33, 40],
                "E" => [41, INF]
            ];
        } elseif ($this->saison_id >= 13) {
            $zuordnung = [
                "A" => [1, 6],
                "AB" => [7, 12],
                "BC" => [13, 18],
                "CD" => [19, 24],
                "DE" => [25, 30],
                "E" => [31, INF]
            ];
        } elseif ($this->saison_id >= 9) {
            $zuordnung = [
                "A" => [1, 6],
                "AB" => [7, 12],
                "BC" => [13, 18],
                "CD" => [19, 24],
                "D" => [25, INF]
            ];
        } elseif ($this->saison_id >= 0) {
            $zuordnung = [
                "" => [1, INF]
            ];
        }

        return $zuordnung;
    }
}