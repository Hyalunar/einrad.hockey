<?php

// Neuer Spieler eintragen
if (isset($_POST['neuer_eintrag'])) {
    $error = false;
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $jahrgang = $_POST['jahrgang'];
    $geschlecht = $_POST['geschlecht'];

    if (($_POST['dsgvo'] ?? '') !== 'zugestimmt') {
        $error = true;
        Html::error("Den Datenschutz-Hiweisen muss zugestimmt werden, um in einem Ligateam spielen zu können.");
    }
    if (empty($vorname) || empty($nachname) || empty($jahrgang) || empty($geschlecht)) {
        $error = true;
        Html::error("Bitte Felder ausfüllen");
    }

    if (!$error) {
        $spieler = new nSpieler();
        if ($spieler
            ->set_vorname($vorname)
            ->set_nachname($nachname)
            ->set_jahrgang($jahrgang)
            ->set_geschlecht($geschlecht)
            ->set_team_id($team_id)
            ->set_letzte_saison(Config::SAISON)
            ->speichern(true)
        ) {
            Html::info("Der Spieler wurde erfolgreich eingetragen.");
            Helper::reload(get:'?team_id=' . $team_id);
        } else {
            Html::error("Der Spieler konnte nicht eingetragen werden.");
        }
    }
}

// Spieler aus der Vorsaison übernehmen
if (isset($_POST['submit_takeover'])) {
    if (($_POST['dsgvo'] ?? '') !== 'zugestimmt') {
        Html::error("Den Datenschutz-Hiweisen muss zugestimmt werden, um in einem Ligateam spielen zu können.");
    } else {
        foreach (($_POST['takeover'] ?? []) as $spieler_id) {
            if (!empty($kader_vorsaison[$spieler_id])) { // Validation + Schutz gegen Html-Manipulation
                $spieler = nSpieler::get($spieler_id);
                $spieler
                    ->set_letzte_saison(Config::SAISON)
                    ->speichern();
                $changed = true;
            }
        }
        if ($changed ?? false) {
            Html::info("Die Spieler wurden in die neue Saison übernommen.");
            (new Team ($team_id))->set_schiri_freilos(); // Check in der Funktion
            header('Location: ' . db::escape($_SERVER['PHP_SELF']) . '?team_id=' . $team_id);
            die ();
        }
    }
}

if (isset($_POST['spieler_aendern'])){
    $selected_spieler = $kader[$_POST['spieler_select']] ?? false;
    $text = $_POST['aenderung_text'] ?? false;
    if(
        $selected_spieler
        && $text
    ) {
        $selected_spieler->change_request($_POST['aenderung_text']);
        Helper::reload();
    } else {
        Html::error("Bitte Spieler und Text angeben.");
    }

}