<?php
/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LOGIK////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
require_once '../../logic/first.logic.php'; //autoloader und Session
require_once '../../logic/session_team.logic.php'; //Auth
require_once '../../logic/challenge.logic.php';


$team_id = $_SESSION["team_id"];

/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LAYOUT///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
include '../../templates/header.tmp.php';
?>

<style>
button {
    border: 0px;
    cursor: pointer;
    background-color: transparent;
    color: gray;
    padding: 5px;
}

button:hover {
    transition: 0.3s;
    color: #e3776f;
}
</style>

<div class="w3-responsive w3-panel">
        <?php
            foreach ($eintraege as $eintrag) {
                if ($eintrag["team_id"] == $team_id) {
        ?> 
                    <div class="w3-panel w3-card-4 w3-text-grey w3-padding-16">
                        <div class="w3-row">
                            <div class="w3-col w3-center" style="width: 23%"><?=date("d.m.Y", strtotime($eintrag['datum']))?></div>
                            <div class="w3-col w3-center" style="width: 23%"><?=$eintrag['vorname']?> <?=$eintrag['nachname']?></div>
                            <div class="w3-col w3-center" style="width: 23%"><?=number_format($eintrag['kilometer'], 1, ',', '.');?> km</div>
                            <div class="w3-col w3-center" style="width: 23%"><?=$eintrag['radgröße']?> Zoll</div>
                            <div class="w3-col w3-right-align" style="width: 8%">
                                <form method="post">
                                    <input type="hidden" name="eintrag_id" value="<?=$eintrag['id']?>"></input>
                                    <button type="submit" name="update_challenge"><i class="material-icons">delete</i></button>
                                </form>
                            </div>
                        </div>
                    </div>
        <?php
                }
            }
        ?>  
</div>

<?php
include '../../templates/footer.tmp.php';