<?php

class Archiv
{
    public static function archivieren(int $saison)
    {
        self::transfer_teams($saison);
        self::transfer_turniere($saison);
        self::transfer_spiele($saison);
        self::transfer_ergebnisse($saison);
        self::transfer_turnierdetails($saison);
        self::transfer_teamstrafen($saison);
        self::transfer_spielplandetails($saison);
    }

    /**
     * Übertragen der Teams in die Archivdatenbank.
     * @param $saison
     */
    public static function transfer_teams(int $saison)
    {       
        $extract_sql = "
            SELECT team_id, ? as saison, teamname, ligateam
            FROM `teams_liga`
            WHERE aktiv = 'Ja'
        ";

        $insert_sql = "
            INSERT INTO archiv_teams_liga (team_id, saison, teamname, ligateam)
            VALUES (?, ?, ?, ?)
        ";
        
        $result = db::$db->query($extract_sql, $saison)->esc()->fetch();

        foreach ($result as $team) {
            db::$archiv->query($insert_sql, $team['team_id'], $team['saison'], $team['teamname'], $team['ligateam']);
        }
    }

    /**
     * Übertragen der Turniere in die Archivdatenbank.
     * @param $saison
     */
    public static function transfer_turniere(int $saison) 
    {
        $extract_sql = "
            SELECT turniere_liga.turnier_id, saison, spieltag, datum, plaetze, tblock, art
            FROM turniere_liga
            LEFT JOIN turniere_details ON turniere_liga.turnier_id = turniere_details.turnier_id
            WHERE saison = ?
            AND phase = 'ergebnis'
        ";

        $insert_sql = "
            INSERT INTO archiv_turniere_liga (turnier_id, saison, spieltag, datum, plaetze, tblock, art) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ";

        $result = db::$db->query($extract_sql, $saison)->esc()->fetch();

        foreach ($result as $turnier) {
            db::$archiv->query($insert_sql, $turnier['turnier_id'], $turnier['saison'], $turnier['spieltag'], $turnier['datum'], $turnier['plaetze'], $turnier['tblock'], $turnier['art']);
        }
    }

    /**
     * Übertragen der Spiele in die Archivdatenbank.
     * @param $saison
     */
    public static function transfer_spiele(int $saison)
    {
        $extract_sql = "
            SELECT spiele.*
            FROM spiele
            LEFT JOIN turniere_liga ON spiele.turnier_id = turniere_liga.turnier_id
            WHERE turniere_liga.saison = ?
        ";

        $insert_sql = "
            INSERT INTO archiv_turniere_spiele (turnier_id, spiel_id, team_id_a, team_id_b, schiri_team_id_a, schiri_team_id_b, tore_a, tore_b, penalty_a, penalty_b)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";  

        $result = db::$db->query($extract_sql, $saison)->esc()->fetch();      

        foreach ($result as $spiel) {
            db::$archiv->query($insert_sql, $spiel['turnier_id'], $spiel['spiel_id'], $spiel['team_id_a'], $spiel['team_id_b'], $spiel['schiri_team_id_a'], $spiel['schiri_team_id_b'], $spiel['tore_a'], $spiel['tore_b'], $spiel['penalty_a'], $spiel['penalty_b']);
        }
    }

    public static function transfer_ergebnisse(int $saison)
    {
        $extract_sql = "
            SELECT turniere_ergebnisse.team_id, turniere_ergebnisse.turnier_id, ergebnis, platz
            FROM turniere_ergebnisse
            LEFT JOIN turniere_liga ON turniere_ergebnisse.turnier_id = turniere_liga.turnier_id
            WHERE turniere_liga.saison = ?
        ";

        $insert_sql = "
            INSERT INTO archiv_turniere_ergebnisse (team_id, turnier_id, ergebnis, platz)
            VALUES (?, ?, ?, ?)
        ";  

        $result = db::$db->query($extract_sql, $saison)->esc()->fetch();      

        foreach ($result as $ergebnis) {
            db::$archiv->query($insert_sql, $ergebnis['team_id'], $ergebnis['turnier_id'], $ergebnis['ergebnis'], $ergebnis['platz']);
        }
    }

    public static function transfer_turnierdetails(int $saison)
    {
        $extract_sql = "
            SELECT turniere_liga.turnier_id, tname, hallenname, startzeit, ausrichter, ort, format
            FROM turniere_liga
            LEFT JOIN turniere_details ON turniere_liga.turnier_id = turniere_details.turnier_id
            WHERE turniere_liga.phase = 'ergebnis'
            AND saison = ?
        ";

        $insert_sql = "
            INSERT INTO archiv_turniere_details (turnier_id, tname, hallenname, startzeit, ausrichter, ort, format)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ";        

        $result = db::$db->query($extract_sql, $saison)->esc()->fetch();

        foreach ($result as $detail) {
            db::$archiv->query($insert_sql, $detail['turnier_id'], $detail['tname'], $detail['hallenname'], $detail['startzeit'], $detail['ausrichter'], $detail['ort'], $detail['format']);
        }
    }

    public static function transfer_teamstrafen(int $saison)
    {
        $extract_sql = "
            SELECT team_id, turnier_id, prozentsatz
            FROM teams_strafen
            WHERE saison = ?
        ";

        $insert_sql = "
            INSERT INTO archiv_teams_strafen (team_id, turnier_id, strafe)
            VALUES (?, ?, ?)
        ";

        $result = db::$db->query($extract_sql, $saison)->esc()->fetch();

        foreach ($result as $strafe) {
            db::$archiv->query($insert_sql, $strafe['team_id'], $strafe['turnier_id'], $strafe['strafe']);
        }
    }

    public static function transfer_spielplandetails(int $saison)
    {
        $extract_sql = "
            SELECT spielplan, plaetze, anzahl_halbzeiten, halbzeit_laenge, puffer, pausen
            FROM spielplan_details
            LEFT JOIN turniere_liga ON turniere_liga.spielplan_vorlage = spielplan_details.spielplan
            WHERE turniere_liga.saison = ?
        ";

        $insert_sql = "
            INSERT INTO archiv_spielplan_details (spielplan, plaetze, anzahl_halbzeiten, halbzeit_laenge, puffer, pausen)
            VALUES (?, ?, ?, ?, ?, ?)
        ";

        $result = db::$db->query($extract_sql, $saison)->esc()->fetch();

        foreach ($result as $spielplan) {
            db::$archiv->query($insert_sql, $spielplan['spielplan'], $spielplan['plaetze'], $spielplan['anzahl_halbzeiten'], $spielplan['halbzeit_laenge'], $spielplan['puffer'], $spielplan['pausen']);
        }
    }

    public static function get_uebersicht()
    {
        $uebersicht = array();
        $anz_saisons = Config::SAISON - 1;
        for ($i = $anz_saisons; $i >= 0; $i--) {
           $saison = new Archiv_Saison($i);
           $uebersicht[$i] = $saison;
        }

        return $uebersicht;
    }
}