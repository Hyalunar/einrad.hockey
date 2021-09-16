<?php
/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LOGIK////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
require_once '../../init.php';
require_once '../../logic/session_team.logic.php'; //Auth

// Teamspezifisches
$team = new Team($_SESSION['logins']['team']['id']);
$turnier_angemeldet = $team->get_turniere_angemeldet();
$anz_freilose = $team->get_freilose();

// Relevante Turniere finden
$heute = date("Y-m-d");
$db_turniere = nTurnier::get_turniere_kommend();

// Hinweis Live-Spieltag
$akt_spieltag = Tabelle::get_aktuellen_spieltag();
if (Tabelle::check_spieltag_live($akt_spieltag)){
    Html::notice(
        "Für den aktuelle Spieltag (ein Spieltag ist immer ein ganzes Wochenende) wurden noch nicht alle Ergebnisse eingetragen. Für die Turnieranmeldung gilt immer der Teamblock des letzten vollständigen Spieltages: "
        . Html::link("../liga/tabelle.php?spieltag=" . ($akt_spieltag - 1) . "#rang", "Spieltag " . ($akt_spieltag - 1)));
}

// Links
$turniere[$turnier_id]['links'] = 
array(
    Html::link("tc_team_anmelden.php?turnier_id=" . $turnier_id,'Zur Ab- / Anmeldung', false , 'how_to_reg'),
    Html::link("../liga/turnier_details.php?turnier_id=" . $turnier_id, 'Zu den Turnierdetails', false, 'info')
);

include '../../logic/turnierliste.logic.php';
/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LAYOUT///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
include '../../templates/header.tmp.php';?>

<h2 class="w3-text-primary" style='display: inline;'>Turnieranmeldung und -abmeldung</h2>
<!-- Trigger/Open the Modal -->
<p>
    <button onclick="document.getElementById('id01').style.display='block'" class="w3-button w3-text-primary">
        <?= Html::icon("help") ?> Legende
    </button>
</p>
<!-- The Modal -->
<div id="id01" class="w3-modal">
  <div class="w3-modal-content" style="max-width:400px">
    <div class="w3-container w3-card-4 w3-border w3-border-black">
      <span onclick="document.getElementById('id01').style.display='none'"
      class="w3-button w3-display-topright">&times;</span>
        
        <h3>Legende:</h3>
        <p>
        Reihen:<br>
        <span class="w3-pale-green">Auf Spielen-Liste<br></span>
        <span class="w3-pale-blue">Auf Warteliste<br></span>
        <span class="w3-pale-yellow">Auf Meldeliste<br></span>
        <br>
        <i><span class="w3-text-green">(Block)</span>: Anmeldung möglich</i><br>
        <i><span class="w3-text-yellow">(Block)</span>: Freilos möglich</i><br>
        <i><span class="w3-text-red">(Block)</span>: Falscher Block</i><br>
        <br>
        <i><span class="w3-text-green">frei</span>: Plaetze auf der Spielen-Liste frei</i><br>
        <i><span class="w3-text-red">voll</span>: Spielen-Liste ist voll</i><br>
        </p>
    </div>
  </div>
</div>


<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
<?php include '../../templates/turnierliste.tmp.php';?>

<?php include '../../templates/footer.tmp.php';