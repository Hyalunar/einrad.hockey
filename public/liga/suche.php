<?php
/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LOGIK////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////

// Pfad muss angepasst werden
require_once '../../logic/first.logic.php'; //autoloader und Session
// require_once '../../logic/session_la.logic.php'; // Ligaausschusslogin erforderlich
// require_once '../../logic/session_team.logic.php'; // Teamlogin erforderlich


// Data für Html-Code
$teams = Team::get_liste();

/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LAYOUT///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////

include Env::BASE_PATH . '/templates/header.tmp.php'; ?>

<!--    <h1 class="w3-text-primary">Auf der Seite suchen:</h1>-->
<!---->
<!--    <input id="searchBox" type="search" placeholder="Suche" />-->
<!---->

<?php include Env::BASE_PATH . '\templates\footer.tmp.php';