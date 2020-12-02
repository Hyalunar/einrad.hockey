                </div>
            </div>
        </main>
        <footer class="w3-container w3-margin-top w3-center w3-cell-bottom w3-primary">
            <div class="w3-center">
                <a href="../liga/kontakt.php" class="w3-button"><i class="material-icons">mail</i> Kontakt</a>
                <a href="<?=Config::LINK_FACE?>" class="w3-button" target="_blank" rel="noopener noreferrer"><i class="material-icons">group_add</i> Facebook</a>
                <a href="<?=Config::LINK_INSTA?>" class="w3-button" target="_blank" rel="noopener noreferrer"><i class="material-icons">camera_alt</i> Instagram</a>
            </div>
            <div class="w3-center">
                <a href="../liga/ligaleitung.php" class="w3-button"><i class="material-icons">account_box</i> Ligaleitung</a>
                <a href="../liga/datenschutz.php" class="w3-button"><i class="material-icons">security</i> Datenschutz</a>
                <a href="../liga/impressum.php" class="w3-button"><i class="material-icons">view_headline</i> Impressum</a>
            </div>
        </footer>
    </body>
</html>
<?php 
//Logs der Besucher
$url = $_SERVER['REQUEST_URI'];
if (!isset($_SESSION['id_for_debug'])){
    $_SESSION['id_for_debug'] = session_id();
}
if (!isset($_SESSION['start_zeit'])){
    $_SESSION['start_zeit'] = time();
}
$delta_load_time = microtime(TRUE) - $_SERVER["REQUEST_TIME_FLOAT"];
$delta_user_time = str_pad((time() - $_SESSION['start_zeit'])." s", 6, " ");
$line = $_SESSION['id_for_debug'] . " | " . $delta_user_time . "(use) | " . $_SERVER['REQUEST_URI'] . " | " . round($delta_load_time, 3) . " s (load)";
Form::log("log_visits.log", $line);
?>