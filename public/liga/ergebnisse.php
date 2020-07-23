<?php
/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LOGIK////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
require_once '../../logic/first.logic.php'; //autoloader und Session

if (isset($_GET['saison']) && is_numeric($_GET['saison'])){
    $saison = $_GET['saison'];
}else{
    $saison = Config::SAISON;
}
$data_ergebnisse = Tabelle::get_all_ergebnisse($saison);

if (empty($data_ergebnisse)){
    Form::affirm("Es wurden noch keine Turnierergebnisse der Saison $saison eingetragen");
}
$data_turniere = Turnier::get_all_turniere("WHERE saison='$saison'");
$color[0] = "w3-text-tertiary";
$color[1] = "w3-text-grey";
$color[2] = "w3-text-brown";

/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LAYOUT///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
$titel = "Turnierergebnisse " . Form::get_saison_string($saison) . " | Deutsche Einradhockeyliga";
$content = 'Hier kann man die Ergebnisse und Tabellen seit der ersten Saison im Jahr 1995 sehen.';
include '../../templates/header.tmp.php';
?>

<!--Javascript für Suchfunktion-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
//Turnierergebnisse filtern
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myDIV section").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

<!--Überschrift-->
<h1 class="w3-text-primary">Turnierergebnisse<br><span class="w3-text-grey">Saison <?=Form::get_saison_string($saison)?></span></h1>

<!-- Team suchen -->
<div class="w3-section" style="max-width: 280px;">
    <input id="myInput" class='w3-input w3-border-grey' type="text" placeholder="Ergebnis suchen">
</div>

<!--Turnierergebnisse-->
<div id="myDIV">
    <?php foreach($data_ergebnisse as $turnier_id => $ergebnisse){?>
        <section class="w3-card w3-panel" id="<?=$turnier_id?>">
            <h3><?=date("d.m.Y", strtotime($data_turniere[$turnier_id]['datum']))?> <span class="w3-text-primary"> <?=$data_turniere[$turnier_id]['tname'] ?? ''?> <?=$data_turniere[$turnier_id]['ort']?></span> <i>(<?=$data_turniere[$turnier_id]['tblock']?>)</i></h3>  
            <div class="w3-responsive w3-margin-left">
                <table class="w3-table w3-striped w3-leftbar w3-border-tertiary" style="max-width: 600px">
                <!--<thead class="">
                        <tr>
                            <th colspan="2"><b>Turnierergebnis</b></th>
                            <th>Punkte</th>
                        </tr>
                    </thead>-->
                    <?php foreach ($ergebnisse as $key => $ergebnis){?>
                        <tr class="<?=$color[$key] ?? ''?>">
                            <td><?=$key + 1 . "."?></td>
                            <td><?=$ergebnis['teamname']?></td>
                            <td><?=$ergebnis['ergebnis'] ?: '-'?></td>
                        </tr> 
                    <?php } //end foreach?>
                </table>
            </div>
            <p class="">
                <?php if ($saison <= 25){?>
                    <?=Form::link('archiv.php','<i class="material-icons">info</i> Details')?>
                <?php }else{ ?>
                    <a href="<?=$data_turniere[$turnier_id]['link_spielplan'] ?? '#'?>" class="<?php if(empty($data_turniere[$turnier_id]['link_spielplan'])){?>w3-opacity-max<?php }// end if?> no w3-text-blue w3-hover-text-secondary">
                        <i class="material-icons">info</i>Details
                    </a>
                <?php }//end if?>
            </p>
        </section>
    <?php } //end foreach?>
</div>

<?php include '../../templates/footer.tmp.php';