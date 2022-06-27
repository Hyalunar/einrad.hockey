<?php

namespace App\Service\Team;

use App\Entity\Team\nTeam;
use App\Entity\Turnier\Turnier;
use App\Entity\Turnier\TurniereListe;
use App\Repository\DoctrineWrapper;
use App\Service\Turnier\TurnierService;
use Env;
use Html;
use Config;

class TeamValidator
{

    public static function hasGenugSpieler(nTeam $team): bool
    {
        return TeamService::getAnzahlAktiveSpieler($team) >= 5;
    }

    public static function hasSchiriFreilosErhalten(nTeam $team): bool
    {
            return $team->getZweitesFreilos() != null
                && $team->getZweitesFreilos()->getTimestamp() >= strtotime(Config::SAISON_WECHSEL);
    }

    /**
     * Ermittelt, ob das Team an gleichen Kalendertag auf einem anderen Turnier angemeldet ist
     *
     * @param Turnier $turnier
     * @param nTeam $team
     * @return bool
     */
    public static function isAmKalenderTagAufSetzliste(Turnier $turnier, nTeam $team): bool //TODO ins repo
    {
        $query = DoctrineWrapper::manager()
            ->createQueryBuilder()
            ->select('l.listeId')
            ->from(TurniereListe::class, 'l')
            ->innerJoin('l.turnier', 't')
            ->where('l.team = :team')
            ->andWhere('t.datum = :datum')
            ->andWhere("t.art = 'I' OR t.art = 'II'")
            ->andWhere("t.canceled = 0")
            ->andWhere("l.liste = 'setzliste'")
            ->andWhere('t.id != :turnierId')
            ->setParameter('team', $team)
            ->setParameter('turnierId', $turnier->id())
            ->setParameter('datum', $turnier->getDatum());
        return count($query->getQuery()->getResult()) > 0;
    }

    public static function isValidTurnierForAnmeldung(nTeam $team, Turnier $turnier): bool
    {
        $valid = true;
        $name = $team->getName();
        if (TeamService::isAufSetzliste($team, $turnier)) {
            Html::error("Das Team $name ist bereits auf der Setzliste.");
            $valid = false;
        } elseif (self::isAmKalenderTagAufSetzliste($turnier, $team)) {
            Html::error("Das Team $name ist bereits auf einem anderen Turnier auf der Setzliste.");
            $valid = false;
        }

        if ($turnier->isSpielplanPhase() || $turnier->isErgebnisPhase()) {
            Html::error("Eine Anmeldung ist nicht mehr möglich, da der Spielplan schon erstellt wurde.");
            $valid = false;
        }

        if (!$turnier->isLigaturnier()) {
            Html::error("Anmeldungen zu Turnieren dieser Art sind im Teamcenter nicht möglich.");
            $valid = false;
        }

        return $valid;
    }

    public static function isValidRegularAnmeldung(nTeam $team, Turnier $turnier): bool
    {
        $valid = self::isValidTurnierForAnmeldung($team, $turnier);

        if (TeamService::isAufWarteliste($team, $turnier)) {
            Html::error("Das Team " . $team->getName() . " ist bereits auf der Warteliste angemeldet.");
            $valid = false;
        }
        if (!TurnierService::isSpielBerechtigt($turnier, $team)) {
            Html::error("Der Teamblock " . $team->getBlock() . " passt nicht zum Turnierblock "
                . $turnier->getBlock() . "."
            );
            $valid = false;
        }
        return $valid;
    }

    public static function isValidAbmeldung(nTeam $team, Turnier $turnier): bool
    {
        $valid = true;

        if (
            TeamService::isAufSetzliste($team, $turnier)
            && TurnierService::getAbmeldeFristUnix($turnier) < time()
        ) {
            $valid = false;
            Html::error ("Abmeldungen von der Spielen-Liste sind nur bis Freitag 23:59 zwei Wochen vor dem 
                Turnier möglich. Bitte nehmt via Email Kontakt mit dem Ligaausschuss auf: "
                . Html::mailto(Env::LAMAIL). "",
                esc:false
            );
        }

        if (!TeamService::isAngemeldet($team, $turnier)){
            $valid = false;
            Html::error ("Abmeldung nicht möglich, da ihr nicht zum Turnier angemeldet seid.");
        }

        return $valid;
    }

    public static function isValidFreilos(nTeam $team, Turnier $turnier): bool
    {
        $valid = self::isValidTurnierForAnmeldung($team, $turnier);

        if (!TurnierService::hasFreieSetzPlaetze($turnier)) {
            Html::error("Es gibt keine freien Plätze mehr auf der Setzliste.");
            $valid = false;
        }

        if ($team->getFreilose() <= 0) {
            Html::error("Dein Team hat keine Freilose zur Verfügung.");
            $valid = false;
        }

        if ($turnier->isSetzPhase() && TurnierService::isSpielBerechtigt($turnier, $team)){
            Html::error ("Dein Team würde auch ohne Freilos auf die Setzliste kommen.");
            $valid = false;
        }

        if (!TurnierService::isSpielBerechtigtFreilos($turnier, $team)) {
            Html::error ("Turnierblock stimmt nicht. Freilose können nur für Turniere mit höheren oder passenden Block gesetzt werden.");
            $valid = false;
        }

        return $valid;
    }

    public static function isValidFinalMeldung(nTeam $teamEntity, Turnier $turnier): bool
    {
        if (!$turnier->isFinalTurnier()){
            Html::error ("Anmeldung fehlgeschlagen.");
            return false;
        }
        if (TeamService::isAngemeldet($teamEntity, $turnier)){
            Html::error ("Dein Team ist schon angemeldet.");
            return false;
        }
        return true;
    }
}