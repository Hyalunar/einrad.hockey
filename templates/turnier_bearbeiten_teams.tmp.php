<!-- Formular -->
<form method="post">
    <div class="w3-panel w3-card-4">
        <h3>Startzeit</h3>
        <p>
            <label class="w3-text-primary" for="startzeit">Startzeit</label>
            <input required type="time" class="w3-input w3-border w3-border-primary" value="<?=$turnier->get_startzeit();?>" style="max-width: 320px" id="startzeit" name="startzeit">
            <i class="w3-text-grey">Turniere dürfen frühestens um 9:00&nbsp;Uhr beginnen und müssen um 20:00&nbsp;Uhr beendet sein</i>
        </p>
        <p>
            <input class="w3-check" type="checkbox" id="besprechung" name="besprechung" <?php if ($turnier->get_besprechung() == "Ja"){?>checked <?php } //endif?>value="Ja">
            <label style="cursor: pointer;" class="w3-hover-text-secondary w3-text-primary" for="besprechung"> Gemeinsame Besprechung aller Teams 15 min vor Turnierbeginn</label>
        </p>
    </div>
    <div class="w3-panel w3-card-4">
        <h3>Turnier erweitern</h3>
        <?php if ($turnier->is_erweiterbar_blockhoch()){ // = true wenn Block erweiterbar ist, aus turnier_details_bearbeiten.logic.php?>
        <p>
        <input type="checkbox" value="<?=Config::BLOCK_ALL[array_search($turnier->get_tblock(), Config::BLOCK_ALL)-1]?>" class="w3-check" id="block_erweitern" name="block_erweitern">
        <label class="w3-text-primary w3-hover-text-secondary" style="cursor: pointer;" for="block_erweitern">Turnierblock erweitern auf <?=Config::BLOCK_ALL[array_search($turnier->get_tblock(), Config::BLOCK_ALL)-1]?></label>
        </p>
        <?php } //endif?>
        <?php if ($turnier->is_erweiterbar_blockfrei()){ // = true wenn Block auf ABCDEF erweiterbar ist, aus turnier_details_bearbeiten.logic.php?>
        <p>
        <input type="checkbox" value="ABCDEF" class="w3-check" id="block_frei" name="block_frei">
        <label class="w3-text-primary w3-hover-text-secondary" style="cursor: pointer;" for="block_frei">Turnierblock erweitern auf ABCDEF</label>
        </p>
        <?php } //endif?>
        <?php if (!$turnier->is_erweiterbar_blockhoch() && !$turnier->is_erweiterbar_blockfrei()){?> Turnierblock kann nicht erweitert werden. <?php if ($turnier->get_phase() == 'offen'){?> <i class="w3-text-grey">(Turniere können ab der Meldephase erweitert werden)</i><?php }/*Phase*/ }/*$block*/?>
        <p>
            <label class="w3-text-primary" for="plaetze">Plätze</label>
            <select required class="w3-select w3-border w3-border-primary" id="plaetze" name="plaetze">
            <option <?php if($turnier->get_plaetze() == '4'){?>selected<?php }elseif(Helper::$teamcenter){?>disabled<?php }?>value="4">4 Teams (nur in Absprache mit dem Ligaausschuss)</option>
                <option <?php if($turnier->get_plaetze() == '5'){?>selected<?php }?> value="5">5 Teams</option>
                <option <?php if($turnier->get_plaetze() == '6'){?>selected<?php }?> value="6">6 Teams</option>
                <option <?php if($turnier->get_plaetze() == '7'){?>selected<?php }?> value="7">7 Teams</option>
                <option <?php if($turnier->get_plaetze() == '8' && $turnier->get_format() === 'gruppen'){?>selected<?php }?> value="8 gruppen">8 Teams (zwei Gruppen)</option>
                <option <?php if($turnier->get_plaetze() == '8' && $turnier->get_format() === 'dko'){?>selected<?php }?> value="8 dko">8 Teams (Doppel-KO)</option>
            </select>
        </p>
    </div>
    <div class="w3-panel w3-card-4">
            <h3>Adresse</h3>
            <div class="w3-section">
                <label class="w3-text-primary" for="hallenname">Hallenname</label>
                <input required type="text" class="w3-input w3-border w3-border-primary" value="<?=$turnier->get_hallenname()?>" id="hallenname" name="hallenname">
            </div>
            <div class="w3-section">
                <label class="w3-text-primary" for="strasse">Straße und Hausnummer</label>
                <input required type="text" class="w3-input w3-border w3-border-primary" value="<?=$turnier->get_strasse()?>" id="strasse" name="strasse">
            </div>
            <div class="w3-section">
                <label class="w3-text-primary" for="plz">PLZ</label>
                <input required type="text" class="w3-input w3-border w3-border-primary" maxlength="5" value="<?=$turnier->get_plz()?>" id="plz" name="plz">
            </div>
            <div class="w3-section">
                <label class="w3-text-primary" for="ort">Ort</label>
                <input required type="text" class="w3-input w3-border w3-border-primary" value="<?=$turnier->get_ort()?>" id="ort" name="ort">
            </div>
            <div class="w3-section">
                <label class="w3-text-primary" for="haltestellen">Haltestellen</label>
                <input type="text" class="w3-input w3-border w3-border-primary" value="<?=$turnier->get_haltestellen()?>" id="haltestellen" name="haltestellen">
                <i class="w3-text-grey">Für die Anfahrt mit öffentlichen Verkehrsmitteln</i>
            </div>
    </div>
    <div class="w3-panel w3-card-4">
        <h3>Turnierdetails</h3>
        <p>
            <label class="w3-text-primary" for="hinweis">Hinweistext</label>
            <!--<input type="text" class="w3-input w3-border w3-border-primary" value="<?=$turnier->get_hinweis()?>" id="hinweis" name="hinweis">-->
            <textarea class="w3-input w3-border w3-border-primary" onkeyup="woerter_zaehlen(1500);" maxlength="1500" rows="4" id="text" name="hinweis" required><?=$turnier->get_hinweis()?></textarea>
            <p id="counter"><p>
        </p>
        <p>
            <label class="w3-text-primary" for="startgebuehr">Startgebühr</label>
            <?php if(Helper::$ligacenter){?>
                <input type="text" class="w3-input w3-border w3-border-primary" placeholder="z. B. 5 Euro" value="<?=$turnier->get_startgebuehr()?>" id="startgebuehr" name="startgebuehr">
            <?php }else{ ?>
                <select class="w3-input w3-border w3-border-primary" id="startgebuehr" name="startgebuehr">
                    <option <?php if($turnier->get_startgebuehr() == 'keine'){?>selected<?php }?> value="keine">keine</option>
                    <option <?php if($turnier->get_startgebuehr() == '5 Euro'){?>selected<?php }?> value="5 Euro">5 Euro</option>
                    <option <?php if($turnier->get_startgebuehr() == '6 Euro'){?>selected<?php }?> value="6 Euro">6 Euro</option>
                    <option <?php if($turnier->get_startgebuehr() == '7 Euro'){?>selected<?php }?> value="7 Euro">7 Euro</option>
                    <option <?php if($turnier->get_startgebuehr() == '8 Euro'){?>selected<?php }?> value="8 Euro">8 Euro</option>
                    <option <?php if($turnier->get_startgebuehr() == '9 Euro'){?>selected<?php }?> value="9 Euro">9 Euro</option>
                    <option <?php if($turnier->get_startgebuehr() == '10 Euro'){?>selected<?php }?> value="10 Euro">10 Euro</option>
                    <option <?php if($turnier->get_startgebuehr() == '11 Euro'){?>selected<?php }?> value="11 Euro">11 Euro</option>
                    <option <?php if($turnier->get_startgebuehr() == '12 Euro'){?>selected<?php }?> value="12 Euro">12 Euro</option>
                    <option <?php if($turnier->get_startgebuehr() == '13 Euro'){?>selected<?php }?> value="13 Euro">13 Euro</option>
                    <option <?php if($turnier->get_startgebuehr() == '14 Euro'){?>selected<?php }?> value="14 Euro">14 Euro</option>
                    <option <?php if($turnier->get_startgebuehr() == '15 Euro'){?>selected<?php }?> value="15 Euro">15 Euro</option>
                </select>
            <?php } //end if?>
        </p>
    </div>
    <div class="w3-panel w3-card-4">
        <h3>Organisator</h3>
        <p>
            <label class="w3-text-primary" for="organisator">Name</label>
            <input required value="<?=$turnier->get_organisator()?>" type="text" class="w3-input w3-border w3-border-primary" id="organisator" name="organisator">
        </p>
        <p>
            <label class="w3-text-primary" for="handy">Handy</label>
            <input required value="<?=$turnier->get_handy()?>" type="text" class="w3-input w3-border w3-border-primary" id="handy" name="handy">
            <i class="w3-text-grey">Das Handy muss am Turniertag erreichbar sein</i>
        </p>
    </div>
    <div class="w3-panel w3-card-4">
        <p>
            <input type="submit" value="Turnierdaten ändern" name="change_turnier" class="w3-tertiary w3-button w3-block">
        </p>
    </div>
</form>