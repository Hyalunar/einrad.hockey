<?php
/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LOGIK////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
require_once '../../init.php';

/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LAYOUT///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
Html::$titel = "Nachwuchstraining | Deutsche Einradhockeyliga";
Html::$content = "Diese Seite gibt Informationen über den Nationalkader";
include Env::BASE_PATH . '/templates/header.tmp.php';
?>
<p class="w3-text-gray">Nachwuchstraining</p>
<h1 class="w3-text-primary">Leistungsorientiertes Nachwuchstraining</h1>

<p>
    Das deutsche <?= Html::link("nationalkader.php", "Nationalteam", false, '') ?> soll durch starke Leistungen einerseits das deutsche Einradhockey vertreten, 
    andererseits aber auch Zugkraft für Spieler:innen, Teams und Liga bringen. Der neue Kader wurde bewusst in seiner jetzigen Konstellation zunächst 
    nur bis zur Unicon 2022 festgelegt. Es wird also möglich sein, durch starke Leistung die "alten Hasen" zu verdrängen bzw. in deren Fußstapfen zu treten und 
    somit langfristig das Niveau in der Liga zu erhöhen. Dafür sollen junge, motivierte und leistungsorientierte Spieler:innen gezielt in Form von 
    Trainingslagern gefördert werden.
</p>

<p>
    Dabei richtet sich das Angebot vor allem an Spieler:innen von 14-21 Jahren (Jahrgang 2000-2007), die individuell (also nicht zwangsläufig deren Team) 
    ein Spielniveau von mindestens CD und Potenzial haben.<br>
    Wir freuen uns über alle, die motiviert sind, brauchen für ein effektives Training aber ein Mindestniveau. Daher scheut euch nicht, euch anzumelden! 
    Aber habt auch Verständnis, dass wir bei zu vielen Teilnehmer:innen vorab eine Auswahl treffen müssen.<br>
    Da wir mit den Trainingslagern nur Impulse setzen können, freuen wir uns über alle Betreuer und Trainer, die bei den Terminen zum Zuschauen 
    dabei sind und so neues Wissen mit in die Vereine nehmen.
</p>

<p>
    Auch darüber hinaus freuen wir uns über jede Form der Unterstützung. Wenn ihr eine Halle für die Trainingslager zur Verfügung stellen könnt und wollt, 
    dann nehmen wir diese gerne an. 
</p>

<p>
    <span class="w3-text-primary w3-large">Kontakt</span><br>
    Für die Anmeldung zum Nachwuchstraining und auch weitere Fragen meldet euch gerne unter <?= Html::link("mailto:nachwuchs@einrad.hockey", "nachwuchs@einrad.hockey", false, '')?> gerne Rede und Antwort.
</p>


<?php
include Env::BASE_PATH . '/templates/footer.tmp.php';