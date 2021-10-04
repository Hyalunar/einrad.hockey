<?php
/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LOGIK////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
require_once '../../init.php';
require_once '../../logic/archiv.logic.php';

$saison_id = $_GET['saison'];
$saison = new Archiv_Saison($saison_id);

// Meisterschaftstabelle am Ende der Saison
$meisterschafts_tabelle = Tabelle::get_meisterschafts_tabelle(99, $saison->get_saison_id(), FALSE);

// Da die Rangtabelle erst mit der Saison 2016 (ID 21) eingeführt wurde, wird diese vorher nicht ausgegeben
if ($saison->get_saison_id() >= 21) {
    // Rangtabelle am Ende der Saison
    $rang_tabelle = Tabelle::get_rang_tabelle(99, $saison->get_saison_id(), FALSE);
} else {
    $rang_tabelle;
}

/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LAYOUT///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
Html::$titel = 'Archiv | Deutschen Einradhockeyliga';
Html::$content = 'Hier kann man die Ergebnisse und Tabellen seit der ersten Saison im Jahr 1995 sehen.';
include '../../templates/header.tmp.php';
?>

<!-- Zurück -->
<br>
<?=Html::link("uebersicht.php", "Zurück zum Archiv" , false, "arrow_back")?>

<?php if ($saison->get_saison_id() == 25 || $saison->get_saison_id() == 26): ?>
    <div class="w3-card w3-panel w3-leftbar w3-border-yellow w3-pale-yellow">
        <div class="w3-section">
        Aufgrund der Corona-Pandemie konnte keine Meisterschaft ausgetragen und kein Meister ermittelt werden.
        </div>
    </div>
<?php endif; ?>

<!-- Archiv -->
<h1 class="w3-text-primary">Archiv der Saison <?=$saison->get_saison_string()?></h1>

<p>
    <?=Html::link("turnierliste.php?saison=" . $saison->get_saison_id(), "Alle Turnierdetails" , false, "reorder")?><br>
    <?=Html::link("saison.php?saison=" . $saison->get_saison_id() . "#meister" , "Meisterschaftstabelle" , false, "reorder")?><br>
    <?=Html::link("saison.php?saison=" . $saison->get_saison_id() . "#rang" , "Rangtabelle" , false, "reorder")?>
</p>

<?php 
    if (!empty($saison->get_afinale())):
        Archiv_Turnier::get($saison->get_afinale())->show();
    endif;
    if (!empty($saison->get_quali())):
        Archiv_Turnier::get($saison->get_quali())->show();
    endif;
    if (!empty($saison->get_bfinale())):
        Archiv_Turnier::get($saison->get_bfinale())->show();
    endif;
    if (!empty($saison->get_cfinale())):
        Archiv_Turnier::get($saison->get_cfinale())->show();
    endif;
    if (!empty($saison->get_dfinale())):
        Archiv_Turnier::get($saison->get_dfinale())->show();
    endif;
?>

<h2 id="meister" class="w3-text-secondary">Meisterschaftstabelle</h2>

<?php if ($saison->get_saison_id() >= 21) {?>
    <div class="w3-responsive w3-card">
        <table class="w3-table w3-striped">
            <thead class="w3-primary">
                <tr>
                    <th><b>Platz</b></th>
                    <th><b>Team</b></th>
                    <th><b>Turnierergebnisse</b></th>
                    <th><b>&sum;</b></th>
                </tr>
            </thead>
            <?php foreach ($meisterschafts_tabelle as $spalte){?>
                <tr>
                    <td class="<?=$platz_color[$spalte['platz']] ?? ''?>"><?=$spalte['platz'] ?? ''?></td>
                    <td style="white-space: nowrap"><?=$spalte['teamname']?></td>
                    <td><?=htmlspecialchars_decode($spalte['string'])?></td>
                    <td><?=$spalte['summe'] ?: 0?><?=$spalte['strafe_stern'] ?? ''?></a></td>
                </tr>
            <?php } //end foreach?>
        </table>    
    </div>
<?php } else {?>
    <div class="w3-responsive w3-card">
    <table class="w3-table w3-striped">
        <thead class="w3-primary">
            <tr>
                <th><b>Platz</b></th>
                <th><b>Block</b></th>
                <th><b>Wertung</b></th>
                <th><b>Team</b></th>
                <th><b>Turnierergebnisse</b></th>
                <th><b>&sum;</b></th>
            </tr>
        </thead>
        <?php foreach ($meisterschafts_tabelle as $spalte){?>
            <tr>
                <td class="<?=$platz_color[$spalte['platz']] ?? ''?>"><?=$spalte['platz'] ?? ''?></td>
                <td class="w3-center"><?=$saison->rang_to_block($spalte['platz'])?></td>
                <td class="w3-center"><?=$saison->rang_to_wertigkeit($spalte['platz'])?></td>
                <td style="white-space: nowrap"><?=$spalte['teamname']?></td>
                <td><?=htmlspecialchars_decode($spalte['string'])?></td>
                <td><?=$spalte['summe'] ?: 0?><?=$spalte['strafe_stern'] ?? ''?></a></td>
            </tr>
        <?php } //end foreach?>
    </table>    
</div>
<?php } ?>

<?php if(isset($rang_tabelle)) { ?> 
<h2 id="rang" class="w3-text-secondary">Rangtabelle</h2>
<!-- Rangtabelle -->
<div class="w3-responsive w3-card">
    <table class="w3-table w3-striped">
        <thead class="w3-primary">
            <tr>
                <th><b>#</b></th>
                <th class="w3-center"><b>Block</b></th>
                <th class="w3-center"><b>Wertung</b></th>
                <th><b>Team</b></th>
                <th><b>Turnierergebnisse</b></th>
                <th class="w3-center"><b>&empty;</b></th>
            </tr>
        </thead>
        <?php foreach ($rang_tabelle as $spalte){?>
            <tr>
                <td><span class="w3-text-grey"><?=$spalte['rang']?></span></td>
                <td class="w3-center"><?=$saison->rang_to_block($spalte['rang'])?></td>
                <td class="w3-center"><?=$saison->rang_to_wertigkeit($spalte['rang'])?></td>
                <td style="white-space: nowrap"><?=$spalte['teamname']?></td>
                <td><?=htmlspecialchars_decode($spalte['string'])?></td>
                <td class="w3-center"><?=$spalte['avg'] ?: 0?></td>
            </tr>
        <?php } //end foreach?>
    </table>
</div>
<?php } //end if?>

<?php include '../../templates/footer.tmp.php';