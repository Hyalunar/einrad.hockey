<?php

db::initialize_archiv();

$saison = $_GET['saison'];
$saisondetails = Archiv::get_saisondetails($saison);
$turniere = Archiv::get_turniere($saison);
$meisterschafts_tabelle = Tabelle::get_meisterschafts_tabelle(0, $saison, FALSE);
$rang_tabelle = Tabelle::get_rang_tabelle(0, $saison, FALSE);