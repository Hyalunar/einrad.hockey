<?php
/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LOGIK////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
require_once '../../logic/first.logic.php'; //autoloader und Session
require_once '../../logic/session_la.logic.php'; //Auth

//Formularauswertung
require_once '../../logic/neuigkeit_bearbeiten.logic.php';

Html::notice("Die Verwendung von Html-Tags ist als Ligaausschuss standardmäßig aktiviert.");

/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LAYOUT///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
include '../../templates/header.tmp.php';
include '../../templates/neuigkeit_bearbeiten.tmp.php';
include '../../templates/footer.tmp.php';