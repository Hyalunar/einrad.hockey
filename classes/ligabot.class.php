<?php

/**
 * Class LigaBot
 */
class LigaBot
{

    /**
     * Führt den Ligabot aus
     */
    public static function liga_bot()
    {

        db::db_sichern(); // Datenbank wird gesichert

        $doppel_anmeldungen = self::get_doppel_anmeldungen(); // Doppelt auf Spiele-Liste wird hier erfasst.
        if (!empty($doppel_anmeldungen)) {
            Form::attention("Doppelt auf Spielen-Liste:");
            db::debug($doppel_anmeldungen); //TODO Mail absenden
        }

        $_SESSION['ligabot'] = 'Ligabot'; // Wird in den sql_logs als Autor für die SQL-Befehle verwendet
        $heute = Config::time_offset();  // Datum Heute als Unix-Time

        self::set_spieltage(); // Setzt alle Spieltage der Turniere

        $liste = self::get_turnier_ids(); // Liste aller relevanten Turnierids sortiert nach Turnierdatum
        foreach ($liste as $turnier_id) { // Schleife durch alle Turniere
            $akt_turnier = new Turnier ($turnier_id);
            /**
             * Turnierblock wandern lassen
             */
            $ausrichter_block = Tabelle::get_team_block($akt_turnier->details['ausrichter']);
            $turnier_block = $akt_turnier->details['tblock'];
            // Position des Ausrichters in einem Array aller Blöcke in der Klasse Config, um Blockhöhere und erweiterte
            // Turniere erkennen zu können
            $pos_ausrichter = array_search($ausrichter_block, Config::BLOCK_ALL);
            $pos_turnier = array_search($turnier_block, Config::BLOCK_ALL);

            if ($akt_turnier->details['art'] == 'I' && $akt_turnier->details['phase'] == 'offen' && $akt_turnier->details['tblock_fixed'] != 'Ja' && $turnier_block != $ausrichter_block) {
                if (($pos_ausrichter - 1) != $pos_turnier) { // Um einen Block vom Ausrichterblock aus erweiterte Turniere sollen nicht wandern...
                    $akt_turnier->set_turnier_block($ausrichter_block);
                    $akt_turnier->schreibe_log("Turnierblock gewandert (I): \r\n $turnier_block -> $ausrichter_block", "Ligabot");
                }
            }
            if ($akt_turnier->details['art'] == 'II' && $akt_turnier->details['tblock_fixed'] != 'Ja' && $akt_turnier->details['phase'] == 'offen') {
                if ($pos_ausrichter < $pos_turnier) {
                    $akt_turnier->set_turnier_block($ausrichter_block);
                    $akt_turnier->schreibe_log("Turnierblock gewandert (II): \r\n $turnier_block -> $ausrichter_block", "Ligabot");
                }
            }

            /**
             * Phasenwechsel von Offene Phase in die Meldephase
             */
            // Prüft, ob wir uns vier Wochen vor dem Spieltag befinden und ob das Turnier in der offenen Phase ist.
            if (self::time_offen_melde($akt_turnier->details['datum']) <= $heute && $akt_turnier->details['phase'] == 'offen') {
                $akt_turnier->set_phase("melde"); //Aktualisiert auch $akt_turnier->get_teamdaten()
                $akt_turnier->schreibe_log("Phase: offen -> melde", "Ligabot");
                // Losen setzt alle Teams in richtiger Reihenfolge auf die Warteliste.
                self::losen($akt_turnier);
                // Füllt die Spielen-Liste auf.
                $akt_turnier->spieleliste_auffuellen("Ligabot", false);
                // Info-Mails versenden.
                MailBot::mail_gelost($akt_turnier);
                // Freie-Plätze-Mails versenden.
                MailBot::mail_plaetze_frei($akt_turnier);
            }
        } //end foreach
        unset($_SESSION['ligabot']);
        Form::affirm("Ligabot erfolgreich ausgeführt");
    }

    /**
     * Geht alle Turniere durch und schreibt den jeweiligen Spieltag in die Datenbank
     */
    public static function set_spieltage()
    {
        $liste = self::get_turnier_ids(); // Liste aller relevanten Turnierids sortiert nach Turnierdatum

        // Initierung
        $spieltag = 0;
        $kw = 0; // Kalenderwoche als Hilfsmittel um Spieltage zu bestimmen

        /**
         * Spieltag identifizieren und in die Tabelle schreiben.
         */
        foreach ($liste as $turnier_id) { // Schleife durch alle Turniere
            $akt_turnier = new Turnier ($turnier_id);
            $datum = strtotime($akt_turnier->details['datum']); // Datum des Turniers als Unix-Time
            $wochentag = date("N", $datum); // Wochentage nummeriert 1 - 7
            // Man muss auch Turniere berücksichtigen, welche nicht am Wochende sind:
            if ($kw != date('W', $datum)) {
                $spieltag = $spieltag + 1;
            }
            $set_spieltag = $spieltag;
            if ($wochentag < 3) { // Turniere die Mo oder Di stattfinden werden dem vorherigen Spieltag zugeordnet
                if ((date('W', $datum) - $kw) <= 1) {
                    if ($spieltag == 0) { // Ansonsten würde Spieltag 0 vergeben, wenn das erste Turnier nicht an einem WE stattfindet
                        $spieltag = 1;
                    }
                    $set_spieltag = $spieltag - 1;
                }
            }
            if ($akt_turnier->details['spieltag'] != $set_spieltag) {// Die Datenbank wird nur beschrieben, wenn sich der Spieltag ändert.
                $akt_turnier->schreibe_log("Spieltag: " . $akt_turnier->details['spieltag'] . " -> " . $set_spieltag, "Ligabot");
                $akt_turnier->set_spieltag($set_spieltag);
            }
            $kw = date('W', $datum); // Kalenderwoche übernehmen für die nächste Iteration
        }
    }

    /**
     * Get alle TurnierIDs um sie im Ligabot abzuarbeiten
     *
     * @param int $saison
     * @return array
     */
    public static function get_turnier_ids(int $saison = Config::SAISON): array
    {
        $sql = "SELECT turnier_id FROM turniere_liga WHERE saison = $saison AND (art='I' OR art='II' OR art='III') ORDER BY datum";
        $result = db::read($sql);
        $return = [];
        while ($x = mysqli_fetch_assoc($result)) {
            array_push($return, $x['turnier_id']);
        }
        return db::escape($return); //array
    }


    /**
     * Ermittelt den Zeitpunkt, wann das Turnier in die Meldephase wechseln soll und gibt diesen Zeitpunk als Unix-Time zurück
     *
     * @param string $datum mit strtotime lesbares Datum
     * @return int
     */
    public static function time_offen_melde(string $datum): int
    {
        $datum = strtotime($datum);
        $tag = date("N", $datum); // Numerische Zahl des Wochentages 1-7
        // Faktor 3.93 und strtotime(date("d-M-Y"..)) -> Reset von 12 Uhr Mittags auf Null Uhr, um Winter <-> Sommerzeit korrekt handzuhaben
        if ($tag >= 3) {
            return strtotime(date("d-M-Y", $datum - 3.93 * 7 * 24 * 60 * 60 + (6 - $tag) * 24 * 60 * 60));
        } else {
            return strtotime(date("d-M-Y", $datum - 3.93 * 7 * 24 * 60 * 60 - $tag * 24 * 60 * 60));
        }
    }

    /**
     * Findet Doppelanmeldungen
     *
     * @return array
     */
    public static function get_doppel_anmeldungen(): array
    {
        $sql = "
                SELECT turniere_liste.team_id, teams_liga.ligateam, COUNT(*), turniere_liga.datum 
                FROM turniere_liste 
                INNER JOIN turniere_liga 
                ON turniere_liste.turnier_id = turniere_liga.turnier_id 
                LEFT JOIN teams_liga 
                ON teams_liga.team_id = turniere_liste.team_id 
                WHERE turniere_liste.liste = 'spiele' 
                AND teams_liga.ligateam = 'Ja' 
                GROUP BY turniere_liga.datum, turniere_liste.team_id 
                HAVING (COUNT(*) > 1)
                ";
        $result = db::read($sql);
        $return = [];
        while ($x = mysqli_fetch_assoc($result)) {
            $return[$x['team_id']] = $x;
        }
        return db::escape($return);
    }

    /**
     * Regelt den Übergang von offen zu melden bezüglich der Teamlisten.
     * setzt die Teams in geloster Reihenfolge auf die Warteliste, also danach: Spielen-Liste auffuellen!
     * @param Turnier $akt_turnier
     * Objekt des Typs Turnier
     *
     * @return bool
     */
    public static function losen(Turnier $akt_turnier): bool
    {
        // Falsche Freilosanmeldungen beim Übergang in die Meldephase abmelden
        Form::affirm($akt_turnier->turnier_id . " wurde gelost.");
        $liste = $akt_turnier->get_anmeldungen();
        foreach (($liste['spiele'] ?? []) as $team) {
            // Das Team hat ein Freilos gesetzt, aber den falschen Freilosblock
            if ($team['freilos_gesetzt'] == 'Ja' && !$akt_turnier->check_team_block_freilos($team['team_id'])) {
                $akt_turnier->liste_wechsel($team['team_id'], 'warte');
                Team::add_freilos($team['team_id']);
                $akt_turnier->schreibe_log(
                    "Falscher Freilos-Block: " . $team['teamname'] . "\r\n Teamblock: " . Tabelle::get_team_block($team['team_id']) . " Turnierblock: " . $akt_turnier->daten['tblock'] .
                    "\r\nTeam wurde auf die Warteliste gesetzt, Freilos wurde erstattet", "Ligabot");
                MailBot::mail_freilos_abmeldung($akt_turnier, $team['team_id']);
                // Anmeldeliste aktualisieren
                $liste = $akt_turnier->get_anmeldungen();
            }
        }

        $anz_spiele = count($liste['spiele']);
        $anz_warte = count($liste['warte']);
        $anz_melde = count($liste['melde']);

        // Anzahl der zu losenden Teams
        $anz_los = $anz_warte + $anz_melde + $anz_spiele - $akt_turnier->daten['plaetze'];
        if ($anz_los < 0) {
            $gelost = true;
        }

        $los_nl = $los_rblock = $los_fblock = [];   // 3 Lostöpfe für Nichtligateams, Teams mit richtigem Block und
                                                    // Teams mit falschem Block
        // Aufteilung der Teams in die Lostöpf, Teams mit falschem Freilos wurden schon abgemeldet
        foreach ($liste['melde'] as $team) {
            if ($team['ligateam'] == 'Nein') {
                array_push($los_nl, $team['team_id']);
            } elseif ($akt_turnier->check_team_block($team['team_id'])) {
                array_push($los_rblock, $team['team_id']);
            } else {
                array_push($los_fblock, $team['team_id']);
            }
        }

        // Losen durch "mischen" der Losttöpfe
        shuffle($los_rblock);
        shuffle($los_fblock);
        shuffle($los_nl);

        // Zusammenstellen der neuen Warteliste
        $los_ges = array_merge($los_rblock, $los_nl, $los_fblock);
        $pos = 0;
        foreach ($los_ges as $team_id) {
            $pos += 1;
            if ($akt_turnier->check_doppel_anmeldung($team_id)) { //Check ob das Team am Kalendertag des Turnieres schon auf einer Spiele-Liste steht
                $akt_turnier->abmelden($team_id);
                $akt_turnier->schreibe_log("Abmeldung Doppelanmeldung: \r\n" . Team::teamid_to_teamname($team_id), "Ligabot");
                Form::affirm("Abmeldung Doppelanmeldung im Turnier" . $akt_turnier->turnier_id . ": \r\n" . Team::teamid_to_teamname($team_id));
            } else {
                $akt_turnier->liste_wechsel($team_id, 'warte', $pos);
                $akt_turnier->schreibe_log("Auf Warteliste gelost: \r\n" . Team::teamid_to_teamname($team_id) . " -> $pos", "Ligabot, Los nach Modus");
            }
        }
        // NACH Zusammenstellen der Warteliste via losen, muss die Spielen-Liste über spieleliste_auffuellen aufgefuellt werden!!
        return $gelost ?? false;
    }

    //Alle I,II,III Turniere werden in die Offene Phase geschickt
    //Fürs Debugging
    /*
    public static function zuruecksetzen()
    {
        $liste = self::get_turnier_ids();
        foreach ($liste as $turnier_id){
            $akt_turnier = new Turnier ($turnier_id);
            if ($akt_turnier->get_teamdaten['phase'] != 'ergebnis'){
                $akt_turnier -> set_phase("offen");
                $akt_turnier -> set_spieltag(0);
                $akt_turnier -> schreibe_log("Phase -> offen" , "Zurückgesetzt von Ligabot");
                $akt_turnier -> schreibe_log("Spieltag -> 0" , "Zurückgesetzt von Ligabot");
            }
        }
    }
    */
}