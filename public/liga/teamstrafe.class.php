<?php
class TeamStrafe {

public string $strafe_id;
public ?string $verwarnung;
public ?int $team_id;
public object $team;
public object $turnier;
public ?int $turnier_id;
public ?string $grund;
public ?string $prozentsatz;
public int $saison;
private bool $error = false;

    public function _constructor(): void
    {
        $this->team = nTeam::get($this->team_id);
        $this->turnier = new Turnier($this->turnier_id); //TODO nTurnier erstellen.
    }
    /**
     * @return array
     */
    public function get_verwarnungen(): array
    {
        $sql = "
                SELECT teams_strafen.*
                FROM teams_strafen
                LEFT JOIN turniere_liga
                ON turniere_liga.turnier_id = teams_strafen.turnier_id
                WHERE teams_strafen.saison = ?
                AND teams_strafen.verwarnung = 'Ja'
                ORDER BY turniere_liga.datum DESC 
                ";
        return db::$db->query($sql, Config::SAISON)->fetch_objects(__CLASS__, "strafe_id");
    }

    /**
     * @return string
     */
    public function check_verwarnung(): string
    {
        return $this->verwarnung;
    }

    /**
     */
    public function set_verwarnung(): void
    {
        $this->verwarnung = "Ja";
    }

    /**
     * @return string
     */
    public function get_team_id(): string
    {
        return $this->team_id;
    }

    /**
     * @param nTeam $team
     */
    public function set_team(nTeam $team): void
    {
        $this->team = $team;
        $this->team_id = $team->team_id;
    }

    /**
     * @param Turnier|null $turnier
     * @return TeamStrafe
     */
    public function set_turnier(null|Turnier $turnier)
    {
        if ($turnier) {
            $this->turnier = $turnier;
            $this->turnier_id = $turnier->id;
        }
        return $this;

    }

    /**
     * @return string
     */
    public function get_grund(): string
    {
        return db::escape($this->grund);
    }

    /**
     * @param string $grund
     */
    public function set_grund(string $grund): void
    {
        $this->grund = $grund;
    }

    /**
     * @return string
     */
    public function get_prozentsatz(): string
    {
        return db::escape($this->prozentsatz);
    }

    /**
     * @param string $prozentsatz
     */
    public function set_prozentsatz(string $prozentsatz): void
    {
        $this->prozentsatz = $prozentsatz;
    }

    /**
     * @return string
     */
    public function get_saison(): string
    {
        return Html::get_saison_string($this->saison);
    }

    /**
     * @param string $saison
     */
    public function set_saison(int $saison): void
    {
        $this->saison = $saison;
    }

    public function speichern(): void
    {
        if ($this->error) {
            Html::error("Strafe konnte nicht gespeichet werden.");
            return;
        }
        $sql = "
                    INSERT INTO teams_strafen (team_id, verwarnung, turnier_id, grund, prozentsatz, saison)
                    VALUES (?, ?, ?, ?, ?, ?)
                    ";
        $params = [
            $this->team_id,
            $this->verwarnung,
            $this->turnier_id,
            $this->grund,
            $this->prozentsatz,
            $this->saison
        ];
        db::$db->query($sql, $params)->log();
    }

    /**
     * Teamstrafe löschen
     *
     */
    public function delete(): void
    {
        $sql = "
                    DELETE FROM teams_strafen
                    WHERE strafe_id = ?
                    ";
        db::$db->query($sql, $this->strafe_id)->log();
    }
}