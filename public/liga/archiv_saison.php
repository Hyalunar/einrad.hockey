<?php
/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LOGIK////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
require_once '../../init.php';
require_once '../../logic/archiv.logic.php';
require_once '../../logic/archiv_saison.logic.php';

/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LAYOUT///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
Html::$titel = 'Archiv | Deutschen Einradhockeyliga';
Html::$content = 'Hier kann man die Ergebnisse und Tabellen seit der ersten Saison im Jahr 1995 sehen.';
include '../../templates/header.tmp.php';
?>

<!-- Zurück -->
<br>
<?=Html::link("archiv.php", "Zurück zum Archiv" , false, "reorder")?>

<!-- Archiv -->
<h1 class="w3-text-primary">Archiv der Saison <?=$saison->get_saison_string()?></h1>

<p>
    <?=Html::link("archiv_saison.php?saison=" . $saison->get_saison_id() . "#turniere" , "Turnierliste" , false, "reorder")?><br>
    <?=Html::link("archiv_saison.php?saison=" . $saison->get_saison_id() . "#meister" , "Meisterschaftstabelle" , false, "reorder")?><br>
    <?=Html::link("archiv_saison.php?saison=" . $saison->get_saison_id() . "#rang" , "Rangtabelle" , false, "reorder")?>
</p>

<h2 id="turniere" class="w3-text-secondary">Turnierliste</h2>
<!-- Turnierliste -->
<div class="w3-responsive w3-card">
    <table class="w3-table w3-striped">
        <thead class="w3-primary">
            <tr>
                <th><b>Datum</b></th>
                <th><b>Ort</b></th>
                <th><b>Art</b></th>
                <th><b>Block</b></th>
            </tr>
        </thead>
    <?php foreach ($turniere as $turnier) {?>
        <tr>
            <td><?=strftime("%a", strtotime($turnier['datum']))?>, <?=strftime("%d.%m.", strtotime($turnier['datum']))?></a></td>
            <td><?=Html::link('archiv_turnier.php?turnier_id='. $turnier['turnier_id'], $turnier['ort'], false)?></td>
            <td><?=$turnier['art'] == 'final' ? '--' : $turnier['art']?></td>
            <td><?=$turnier['tblock'] == 'final' ? 'FINALE' : $turnier['tblock'] ?></td>
        </tr>
    <?php } ?>
    </table>
</div>

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