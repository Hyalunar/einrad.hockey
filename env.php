<?php

/**
 * Klasse für Enviroment-Variablen
 * wird in first.logic vor dem Autoloader required
 */
class env
{
    /**
     * Webadresse für Verlinkungen, unabhängig der Ordnerstruktur
     * Auf dem Server ist der Public Ordner mit der Domain verknüpft
     */
    public const BASE_URL = 'http://localhost/einrad.hockey/public';

    /**
     * Basispfad für includes, requires
     */
    public const BASE_PATH = __DIR__; // Das Verzeichnis dieser Datei ist der BASE_PATH

    /**
     * SQL-Datenbank Zugangsdaten
     */
    public const HOST_NAME = 'localhost';
    public const DATABASE = 'sys';
    public const USER_NAME = 'sander';
    public const PASSWORD = 'mysqlpwd';

    /**
     * Mailserver
     *
     * Bei ACTIVATE_EMAIL = true wird versucht Emails zu versenden, bei false werden Debugging-Infos ausgegeben
     * In der Regel unwichtig für Localhost.
     */
    public const ACTIVATE_EMAIL = false;
    public const SMTP_HOST = '--';
    public const SMTP_USER = '--';
    public const SMTP_PW = '--';
    public const SMTP_PORT = 0;

    /**
     * Mailadressen
     */
    public const LAMAIL = 'test@einrad.hockey';
    public const LAMAIL_ANTWORT = 'test@einrad.hockey'; // Wird im BCC gesetzt, bei Mails vom Ligaausschuss
    public const TECHNIKMAIL = 'test@einrad.hockey';
    public const SCHIRIMAIL = 'test@einrad.hockey';
    public const OEFFIMAIL = 'test@einrad.hockey';
}
