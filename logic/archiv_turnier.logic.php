<?php

$turnier_id = $_GET['turnier_id'];
$turnier = Archiv_Turnier::get($turnier_id);
$saison = new Archiv_Saison($turnier->get_saison());

$teams = $turnier->get_teams();
$spiele = $turnier->get_spiele();
$ergebnisse = $turnier->get_ergebnisse();

if ($turnier->get_saison() >= 21) {
    $tabelle = Tabelle::get_rang_tabelle($turnier->get_spieltag(), $turnier->get_saison(), FALSE);
} else {
    $tabelle = Tabelle::get_meisterschafts_tabelle($turnier->get_spieltag(), $turnier->get_saison(), FALSE);
}

$nlteams = FALSE;
foreach ($teams as $team) {
    if ($team['ligateam'] == 'Nein') {
        $nlteams = TRUE; 
    }
}