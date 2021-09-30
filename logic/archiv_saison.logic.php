<?php

$saison_id = $_GET['saison'];

$saison = new Archiv_Saison($saison_id);
$turniere = $saison->get_liste_ligaturniere();

// Meisterschaftstabelle am Ende der Saison
$meisterschafts_tabelle = Tabelle::get_meisterschafts_tabelle(99, $saison->get_saison_id(), FALSE);

// Da die Rangtabelle erst mit der Saison 2016 (ID 21) eingeführt wurde, wird diese vorher nicht ausgegeben
if ($saison->get_saison_id() >= 21) {
    // Rangtabelle am Ende der Saison
    $rang_tabelle = Tabelle::get_rang_tabelle(99, $saison->get_saison_id(), FALSE);
} else {
    $rang_tabelle;
}