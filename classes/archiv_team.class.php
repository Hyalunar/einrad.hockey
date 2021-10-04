<?php

class Archiv_Team {
    
    public ?int $team_id;
    private ?int $saison;
    private ?string $teamname;
    private ?string $ligateam;


    /**
     * Erstellt ein Archiv_Team
     * 
     * @param int $team_id
     * @param int $saison
     * @return Archiv_Team
     */

    public static function get(?int $team_id, ?int $saison): Archiv_Team
    {
        $sql = "
            SELECT *
            FROM archiv_teams_liga
            WHERE team_id = ?
            AND saison = ?
        ";

        return db::$archiv->query($sql, $team_id, $saison)->fetch_object(__CLASS__) ?? new Archiv_Team();
    }

    /**
     * Gibt die team_id
     *
     * @return int
     */
    public function get_team_id(): int
    {
        return $this->team_id;
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
     * Gibt den Teamnamen
     * 
     * @return string
     */
    public function get_teamname(): string
    {
        return $this->teamname;
    }

    /**
     * Gibt die Ligateam-Information
     * 
     * @return string
     */
    public function get_ligateam(): string
    {
        return $this->ligateam;
    }
}