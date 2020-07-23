<?php
//Dies hier muss in jeder geschützten Seite direkt unterhalb von first.logic.php eingefügt werden!
if(!isset($_SESSION['team_id'])) {
  $redirect = db::escape($_SERVER['REQUEST_URI']); //Damit man nach dem Login direkt auf die gewünschte Seite geführt wird
  Form::affirm("Bitte zuerste einloggen");
  header('Location: ../teamcenter/tc_login.php?redirect=' . $redirect);
  die();
}

$akt_team = new Team ($_SESSION['team_id']);
$daten = $akt_team->daten();

if (!isset($no_redirect) && $daten['passwort_geaendert'] == 'Nein'){
  Form::affirm("Bitte ändere zuerst das von uns vergebene Passwort");
  header('Location: tc_pw_aendern.php');
  die();
}

if (!isset($no_redirect) && $daten['ligavertreter'] == ''){
  Form::affirm("Bitte trage einen Ligavertreter ein. Beachte bitte, dass jedes Team nur einen Ligavertreter haben kann.");
  header('Location: tc_teamdaten_aendern.php');
  die();
}

$titel = $_SESSION['teamname'];
$ligacenter = false; //Man kann sich gleichzeitig im Liga- und Teamcenter anmelden
$teamcenter = true; //Hiermit erkennt man, ob man sich gerade im Team- oder Ligacenter befindet, da Session-Variablen seitenübergreifend existieren