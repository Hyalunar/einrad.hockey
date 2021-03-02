<?php

// Besteht die Berechtigung das Turnier zu bearbeiten?
if(!Config::$ligacenter){ // Ligacenter darf alles.
    if ((Config::$teamcenter && ($_SESSION['logins']['team']['id'] ?? 0) != $spielplan->turnier->details['ausrichter'])){
        Html::error("Nur der Ausrichter kann Spielergebnisse eintragen");
        header('Location: ../liga/spielplan.php?turnier_id=' . $turnier_id);
        die();
    }

    // Wird das Turnierergebnis rechtzeitig eingetragen?
    $N = date("N", strtotime($spielplan->turnier->details['datum'])); // Numerischer Wochentag.
    $delta = (8-$N) * 24*60*60 + 18*60*60; // Die Zeit bis zum nächsten Montag 18:00 Uhr von 0:00 Uhr aus gesehen.
    $abgabe = strtotime($spielplan->turnier->details['datum']) + $delta;
    if ($abgabe > time()){
        Html::error("Bitte wende dich an den Ligaausschuss um Ergebnisse nachträglich zu verändern.");
        header('Location: ../liga/spielplan.php?turnier_id=' . $turnier_id);
        die();
    }
}

if (isset($_POST["tore_speichern"])) {
    // Neu eingetragene Tore speichern
    foreach ($spielplan->spiele as $spiel_id => $spiel) {
        if (
            (string) $spiel['tore_a'] === ($_POST["tore_a"][$spiel_id] ?? '')
            && (string) $spiel['tore_b'] === ($_POST["tore_b"][$spiel_id] ?? '')
            && (string) $spiel['penalty_a'] === ($_POST["penalty_a"][$spiel_id] ?? '')
            && (string) $spiel['penalty_b'] === ($_POST["penalty_b"][$spiel_id] ?? '')
        ) {
            continue;
        }
        $spielplan->set_tore(
            $spiel['spiel_id'],
            $_POST["tore_a"][$spiel_id] ?? '',
            $_POST["tore_b"][$spiel_id] ?? '',
            $_POST["penalty_a"][$spiel_id] ?? '',
            $_POST["penalty_b"][$spiel_id] ?? ''
        );
    }
    Html::info('Spielergebnisse wurden gespeichert');
    header('Location: ' . dbi::escape($_SERVER['REQUEST_URI']));
    die();
}

//Turnierergebnisse speichern
if (isset($_POST["turnierergebnis_speichern"])) {

    // Sind alle Spiele gespielt und kein Penalty offen?
    if (!$spielplan->check_turnier_beendet()) {
        Html::error("Es sind noch Spiel- oder Penaltyergebnisse offen. Turnierergebnisse wurden nicht übermittelt.");
        $error = true;
    }

    // Testen ob Turnier tabellentechnisch eingetragen werden darf.
    if (!Tabelle::check_ergebnis_eintragbar($spielplan->turnier)) {
        Html::error("Turnierergebnis kann nicht eingetragen werden. Kontaktiere bitte den Ligaausschuss.");
        $error = true;
    }

    // Testen ob Zweite Runde Penaltys gespielt werden müssen
    if ($spielplan->out_of_scope) {
        Html::error("Es muss noch eine zweite Runde Penaltys gespielt werden.");
        $error = true;
    }

    if (!($error ?? false)) {
        $spielplan->turnier->set_ergebnisse($spielplan->platzierungstabelle);
        Html::info("Das Turnierergebnis wurde dem Ligaausschuss übermittelt und wird jetzt in den Ligatabellen angezeigt.");
        header('Location: ' . dbi::escape($_SERVER['REQUEST_URI']));
        die();
    }

}

// Hinweis Kaderkontrolle und Turnierreport
if (!(new TurnierReport($turnier_id))->kader_check()) {
    Html::info("Bitte kontrolliert die Teamkader und setzt im "
            . Html::link('../teamcenter/tc_turnier_report.php?turnier_id='
            . $turnier_id, 'Turnierreport') . " das entsprechende Häkchen.", esc:false);
}

if(!$spielplan->validate_penalty_ergebnisse()){
    Html::error("Achtung: Es liegen falsch eingetragene Penaltyergebnisse vor.");
}

// Gibt es eine Diskrepanz zwischen Turnierergebnis und in der Datenbank hinterlegtem Turnierergebnis?
$error = false;
$vgl_data = $spielplan->turnier->get_ergebnis();
if (!empty($vgl_data)) {
    if (
        !$spielplan->check_turnier_beendet()
        || count($vgl_data) != $spielplan->anzahl_teams
    ) {
        $error = true;
    } else {
        foreach ($spielplan->platzierungstabelle as $ergebnis) {
            if ($vgl_data[$ergebnis['platz']]['ergebnis'] != $ergebnis['ligapunkte']) {
                $error = true;
            }
        }
    }
    if ($error) {
        Html::notice("Turnierergebnis stimmt nicht mit dem in der Datenbank hinterlegtem Ergebnis überein.");
    }
}