<?php
/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LOGIK////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
require_once '../../init.php';

$schubert = nSpieler::get(31);
$hohlbein = nSpieler::get(156);

/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LAYOUT///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
Html::$titel = "Nationalkader | Deutsche Einradhockeyliga";
Html::$content = "Diese Seite gibt Informationen über den Nationalkader";
include Env::BASE_PATH . '/templates/header.tmp.php';
?>
<p class="w3-text-gray">Nationalkader</p>
<h1 class="w3-text-primary">Gründung eines Nationalteams für die Unicon&nbsp;20 in Grenoble (2022)</h1>

<p>
    Seit nun mehreren Jahren zeigen die Schweizer, was eine Bündelung der Kräfte ausmachen kann. 
    Bei der Leistungssteigerung des Schweizer Nationalteams können selbst die stärksten deutschen Teams in ihren Ligakonstellationen nicht mehr mithalten.
</p>

<p>
    <span class="w3-text-primary w3-large">Auf den Weg machen</span><br>
    Um diesem Trend entgegenzuwirken gab es schon öfter die Idee eines deutschen Nationalkaders, der immerhin aus der größten Einradhockeyliga der Welt schöpfen würde. 
    Der erste Schritt dahin wurde nun gegangen: Für die Unicon&nbsp;20 in Grenoble wurde ein Kader gebildet.
    Aus knapp 40 Bewerber:innen wurden durch ein neutrales Sichtungsteam aktiver und ehemaliger Spieler an zwei Wochenenden im September 2021 insgesamt 22 Spieler:innen ausgewählt.<br><br>
    Der Kader wird an Trainingslagern zusammen spielen und soll in drei Teams eingeteilt werden, die alle beim A-Turnier der Unicon&nbsp;20 antreten werden. 
    Es steht weiterhin jedem Spieler und jeder Spielerin der deutschen Einradhockeliga offen, sich unabhängig davon in einem Team zu organisieren und ebenfalls an der Unicon 20 teilzunehmen.
</p>

<p>
    Das Nationalteam soll durch starke Leistungen einerseits das deutsche Einradhockey vertreten, andererseits aber auch Zugkraft für Spieler, Teams und Liga bringen.
</p>

<p>
    <span class="w3-text-primary w3-large">Eine Perspektive</span><br>
    Der neue Kader wurde bewusst in seiner jetzigen Konstellation zunächst nur bis zur Unicon&nbsp;20 in 2022 festgelegt. 
    Es wird also möglich sein, durch starke Leistung die "alten Hasen" zu verdrängen bzw. in deren Fußstapfen zu treten. 
    Auch langfristig soll damit das Niveau in der Liga zu erhöht werden. Dafür werden junge, motivierte und leistungsorientierte Spieler:innen gezielt in Form von  <?= Html::link("nachwuchs.php", "Trainingslagern", false, '') ?> gefördert werden.
</p>

<p>
    <span class="w3-text-primary w3-large">Kontakt</span><br>
    Für den Nationalkader stehen euch <?=$schubert->get_vorname()?> <?=$schubert->get_nachname()?> (<?=$schubert->get_team()?>) und <?=$hohlbein->get_vorname()?> <?=$hohlbein->get_nachname()?> (<?=$hohlbein->get_team()?>) unter <?= Html::link("mailto:einradhockeykader@gmx.de", "einradhockeykader@gmx.de", false, '')?> gerne Rede und Antwort.
</p>


<?php
include Env::BASE_PATH . '/templates/footer.tmp.php';