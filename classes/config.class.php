<?php

class Config
{
    /**
     * Saison
     */
    public const SAISON = 27; // Saison 0 = Jahr 1995;
    public const SAISON_ANFANG = '16.08.2021';
    public const SAISON_ENDE = '29.05.2022';

    /**
     * Saisontermine
     */
    public const FINALE_EINS = '11.06.2022';
    public const FINALE_ZWEI = '12.06.2022';
    public const FINALE_DREI = '18.06.2022';
    public const FINALE_VIER = '19.06.2022';

    /**
     * Log-Files
     */
    public const LOG_LOGIN = "login.log";
    public const LOG_DB = "db.log";
    public const LOG_KONTAKTFORMULAR = "kontakt.log";
    public const LOG_EMAILS = "emails.log";
    public const LOG_USER = "user.log";


    /**
     * Ligablöcke
     *
     * Reihenfolge bei den Blöcken muss immer hoch -> niedrig sein
     * Für die Block und Wertzuordnung in der Rangtabelle siehe Tabelle::rang_to_block und Tabelle::rang_to_wertigkeit
     *
     */

     /**
     * Mögliche Team-Blöcke
     */
    public const BLOCK = ['A', 'AB', 'BC', 'CD', 'DE', 'EF', 'F'];

    /**
     * Mögliche Turnier-Blöcke
     * Reihenfolge ist wichtig!
     */
    public const BLOCK_ALL = ['ABCDEF', 'A', 'AB', 'ABC', 'BC', 'BCD', 'CD', 'CDE', 'DE', 'DEF', 'EF', 'F'];

    /**
     * Mögliche Finalturnier-Blöcke
     * Reihenfolge ist wichtig!
     */
    public const BLOCK_FINALE = ['AFINALE', 'BFINALE', 'CFINALE', 'DFINALE'];

    /**
     * Rangtabellen-Zuordnung
     */
    public const RANG_TO_BLOCK = [
        "A" => [1, 8],
        "AB" => [9, 16],
        "BC" => [17, 24],
        "CD" => [25, 34],
        "DE" => [35, 46],
        "EF" => [47, 58],
        "F" => [59, INF]
    ];

    /**
     * Turnierarten
     */
    public const TURNIER_ARTEN = ['I', 'II', 'III'];

    /**
     * Ligagebühr
     */
    public const LIGAGEBUEHR = "30&nbsp;€";

    /**
     * Kontaktcenter
     */
    public const BCC_GRENZE = 12;

}