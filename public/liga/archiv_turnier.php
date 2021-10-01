<?php
/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LOGIK////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
require_once '../../init.php';
require_once '../../logic/archiv.logic.php';
require_once '../../logic/archiv_turnier.logic.php';

$counter = 1;

/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LAYOUT///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
Html::$titel = 'Archiv | Deutschen Einradhockeyliga';
Html::$content = 'Hier kann man die Ergebnisse und Tabellen seit der ersten Saison im Jahr 1995 sehen.';
include '../../templates/header.tmp.php';
?>

<!-- Zurück -->
<br>
<?=Html::link("archiv.php", "Zurück zum Archiv" , false, "arrow_back")?><br>
<?=Html::link("archiv_saison.php?saison=" . $turnier->get_saison() , "Zurück zur Saison " . $saison->get_saison_string() , false, "arrow_back")?><br>
<?=Html::link("archiv_turnierliste.php?saison=" . $turnier->get_saison() , "Zurück zur Turnierliste der Saison " . $saison->get_saison_string() , false, "arrow_back")?>

<!-- Archiv -->
<h1 class="w3-text-primary"><?=$turnier->get_ort()?> (<?=$turnier->get_tblock()?>), <?=strftime("%d.%m.%Y", strtotime($turnier->get_datum()))?> (<?=strftime("%A", strtotime($turnier->get_datum()))?>)</h1>

<h2 class="w3-text-primary">Teams</h2>
<div class="w3-responsive w3-card">
    <table class="w3-table w3-striped">
        <thead class="w3-primary">
            <tr>
                <th><b>#</b></th>
                <th><b>Teams</b></th>
                <th><b>Wertigkeit</b></th>
                <th><b>Block</b></th>
            </tr>
        </thead>
    <?php foreach ($teams as $team) {?>
        <tr>
            <td><?=$counter?></td>
            <td><?=$team['ligateam'] == 'Ja' ? $team['teamname'] : $team['teamname'] . '*'?></td>
            <?php if ($turnier->get_saison() >= 21) { ?>
                <td><?=$saison->rang_to_wertigkeit($tabelle[$team['team_id']]['rang'] ?? NULL)?></td>
                <td><?=$saison->rang_to_block($tabelle[$team['team_id']]['rang'] ?? NULL)?></td>
            <?php } else { ?>
                <td><?=$saison->rang_to_wertigkeit($tabelle[$team['team_id']]['platz'] ?? NULL)?></td>
                <td><?=$saison->rang_to_block($tabelle[$team['team_id']]['platz'] ?? NULL)?></td>
            <?php } ?>
        </tr>
    <?php $counter++; } ?>
    </table>
</div>
<p class="w3-text-grey"><?=$nlteams ? '* Nichtligateam' : ''?></p>

<h2 class="w3-text-primary">Spiele</h2>
<?php if(!empty($spiele)) { ?>
<div class="w3-responsive w3-card">
    <table class="w3-table w3-striped">
        <thead class="w3-primary">
            <tr>
                <th><b>Spiel</b></th>
                <th><b>Team A</b></th>
                <th><b>Team B</b></th>
                <th colspan="3" class="w3-center"><b>Ergebnis</b></th>
                <th colspan="3" class="w3-center"><b>Penalty</b></th>
            </tr>
        </thead>
    <?php foreach ($spiele as $spiel) {?>
        <tr>
            <td><?=$spiel['spiel_id']?></td>
            <td><?=$spiel['team_a']?></td>
            <td><?=$spiel['team_b']?></td>
            <td class="w3-right-align"><?=$spiel['tore_a']?></td>
            <td class="w3-center">:</td>
            <td class="w3-right-left"><?=$spiel['tore_b']?></td>
            <td class="w3-right-align"><?=$spiel['penalty_a']?></td>
            <td class="w3-center">:</td>
            <td class="w3-right-left"><?=$spiel['penalty_b']?></td>
        </tr>
    <?php } ?>
    </table>
</div>
<p class="w3-text-grey"><?=$nlteams ? '* Nichtligateam' : ''?></p>
<?php } else { ?>
<div class="w3-card w3-panel w3-leftbar w3-border-yellow w3-pale-yellow">
    <div class="w3-section">
    Die Spielergebnisse können zur Zeit nicht dargestellt werden. Wir bitten um Geduld.
    </div>
</div>
<?php } ?>

<h2 class="w3-text-primary">Turnierergebnis</h2>
<div class="w3-responsive w3-card">
    <table class="w3-table w3-striped">
        <thead class="w3-primary">
            <tr>
                <th><b>Platz</b></th>
                <th><b>Team</b></th>
                <th><b>Punkte</b></th>
            </tr>
        </thead>
    <?php foreach ($ergebnisse as $ergebnis) {?>
        <tr>
            <td><?=$ergebnis['platz']?></td>
            <td><?=$ergebnis['ligateam'] == 'Ja' ? $ergebnis['teamname'] : $ergebnis['teamname'] . '*'?></td>
            <td><?=$ergebnis['ergebnis']?></td>
        </tr>
    <?php } ?>
    </table>
</div>
<p class="w3-text-grey"><?=$nlteams ? '* Nichtligateam' : ''?></p>


<?php include '../../templates/footer.tmp.php';