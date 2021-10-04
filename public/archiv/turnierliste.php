<?php
/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LOGIK////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
require_once '../../init.php';
require_once '../../logic/archiv.logic.php';

$saison_id = $_GET['saison'];
$saison = new Archiv_Saison($saison_id);

$ligaturniere = $saison->get_liste_ligaturniere();
$abschlussturniere = $saison->get_liste_abschlussturniere();

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
<?=Html::link("archiv_saison.php?saison=" . $saison->get_saison_id(), "Zurück zur Saison " . $saison->get_saison_string() , false, "arrow_back")?>

<?php if ($saison->get_saison_id() == 25 || $saison->get_saison_id() == 26): ?>
    <div class="w3-card w3-panel w3-leftbar w3-border-yellow w3-pale-yellow">
        <div class="w3-section">
        Aufgrund der Corona-Pandemie konnte keine Meisterschaft ausgetragen und kein Meister ermittelt werden.
        </div>
    </div>
<?php endif; ?>

<!-- Archiv -->
<h1 class="w3-text-primary">Turnierdetails der Saison <?=$saison->get_saison_string()?></h1>

<p>
    <?=(empty($ligaturniere)) ? '' : Html::link("archiv_turnierliste.php?saison=" . $saison->get_saison_id() . "#liste_liga" , "Liste der Ligaturniere" , false, "reorder") . '<br>'?>
    <?=(empty($abschlussturniere)) ? '' : Html::link("archiv_turnierliste.php?saison=" . $saison->get_saison_id() . "#liste_final" , "Liste der Finalturniere" , false, "reorder") . '<br>'?>
    <?=(empty($ligaturniere)) ? '' : Html::link("archiv_turnierliste.php?saison=" . $saison->get_saison_id() . "#ergebnisse_liga" , "Ergebnisse der Ligaturniere" , false, "reorder") . '<br>'?>
    <?=(empty($abschlussturniere)) ? '' : Html::link("archiv_turnierliste.php?saison=" . $saison->get_saison_id() . "#ergebnisse_final" , "Ergebnisse der Finalturniere" , false, "reorder")?>
</p>

<?php if (!empty($ligaturniere)): ?>
    <!-- Ligaturniere -->
    <h2 id="liste_liga" class="w3-text-secondary">Liste der Ligaturniere</h2>
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
        <?php foreach ($ligaturniere as $turnier): ?>
            <tr>
                <td><?=strftime("%a", strtotime($turnier->get_datum()))?>, <?=strftime("%d.%m.", strtotime($turnier->get_datum()))?></a></td>
                <td><?=Html::link('archiv_turnierliste.php?saison=' . $saison->get_saison_id() . '#'. $turnier->get_turnier_id(), $turnier->get_ort(), false)?></td>
                <td><?=$turnier->get_art() == 'final' ? '--' : $turnier->get_art()?></td>
                <td><?=$turnier->get_tblock()== 'final' ? 'FINALE' : $turnier->get_tblock() ?></td>
            </tr>
        <?php endforeach; ?>
        </table>
    </div>
<?php endif; ?>

<?php if (!empty($abschlussturniere)): ?>
    <!-- Abschlussturniere -->
    <h2 id="liste_final" class="w3-text-secondary">Liste der Finalturniere</h2>
    <div class="w3-responsive w3-card">
        <table class="w3-table w3-striped">
            <thead class="w3-primary">
                <tr>
                    <th><b>Datum</b></th>
                    <th><b>Ort</b></th>
                    <th><b>Name</b></th>
                </tr>
            </thead>
        <?php foreach ($abschlussturniere as $turnier): ?>
            <tr>
                <td><?=strftime("%a", strtotime($turnier->get_datum()))?>, <?=strftime("%d.%m.", strtotime($turnier->get_datum()))?></a></td>
                <td><?=Html::link('archiv_turnier.php?turnier_id='. $turnier->get_turnier_id(), $turnier->get_ort(), false)?></td>
                <td><?=$turnier->get_tname() ?></td>
            </tr>
        <?php endforeach; ?>
        </table>
    </div>
<?php endif; ?>

<?php if (!empty($ligaturniere)): ?>
    <!-- Ergebnisse Ligaturniere -->
    <h2 id="ergebnisse_liga" class="w3-text-secondary">Ergebnisse der Ligaturniere</h2>
    <?php 
        foreach ($ligaturniere as $turnier):
            $turnier->show();
        endforeach;
    ?>
<?php endif; ?>

<?php if (!empty($abschlussturniere)): ?>
    <!-- Ergebnisse Abschlussturniere -->
    <h2 id="ergebnisse_final" class="w3-text-secondary">Ergebnisse der Finalturniere</h2>
    <?php 
        foreach ($abschlussturniere as $turnier):
            $turnier->show();
        endforeach;
    ?>
<?php endif; ?>