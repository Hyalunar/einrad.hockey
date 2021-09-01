<!-- Link Teamdaten ändern -->
<h1 class="w3-text-primary">
    <?= Html::icon("group", tag: "h1") ?> <?= $team->get_teamname() ?>
</h1>
    <p>
        <?= Html::link(
                $team->get_link_teamdaten_aendern(),
                Html::icon('create') . ' Team- und Kontaktdaten ändern')
        ?>
    </p>
<div class="w3-panel w3-card-4">
    <h2 class="w3-text-primary">
        <?= Html::icon("image", tag: "h2") ?> Teamfoto
    </h2>

    <?php if ($team->is_teamfoto()){?>
        <p>
            <img src="<?=$team->get_teamfoto()?>"
                 class="w3-card w3-image"
                 alt="Teamfoto der <?= $team->get_teamname() ?>"
                 style="max-height: 360px;">
        </p>
    <?php }else{?>
        <p class="w3-text-grey">Es wurde noch kein Teamfoto hochgeladen.</p>
    <?php } //end if?>

</div>

<div class="w3-panel w3-card-4">
    <h2 id="trikotfarbe" class="w3-text-primary">
        <?= Html::icon("brush", tag: "h2") ?> Trikotfarben
    </h2>

    <div class="w3-row-padding w3-center w3-strech">
        <div class="w3-half">
                <p>
                    1. Trikotfarbe
                </p>
                <span class="w3-card-4"
                      style="height:70px;
                              width:70px;
                              background-color:<?= $team->check_trikot_farbe(1) ? '#bbb' : $team->get_trikot_farbe(1)?>;
                              border-radius:50%;
                              display:inline-block;">
                    <br>
                    <?= $team->check_trikot_farbe(1) ? Html::icon('not_interested') : '' ?>
                </span>
        </div>

        <div class="w3-half">
                <p>
                    2. Trikotfarbe
                </p>
                <span class="w3-card-4"
                      style="height:70px;
                              width:70px;
                              background-color:<?= $team->check_trikot_farbe(2) ? '#bbb' : $team->get_trikot_farbe(2) ?>;
                              border-radius:50%;
                              display:inline-block;">
                    <br>
                    <?= ($team->check_trikot_farbe(2)) ? Html::icon('not_interested') : '' ?>
                </span>
        </div>
    </div>
    <p class="w3-text-grey">
        Eure Trikotfarben werden im Spielplan angezeigt. Sie helfen anderen Teams bei der Wahl ihrer Trikots und Zuschauern dein Team zu identifizieren.
    </p>
</div>

<h2 class="w3-text-primary">
    <?= Html::icon("info", tag: "h2") ?> Teamdaten
</h2>
<div class="w3-responsive w3-card-4">
    <table class="w3-table w3-striped">
        <tr>
            <th class="w3-primary" style="width: 140px">Teamname</th>
            <td><b><?=$team->get_teamname()?></b></td>
        </tr>
        <tr>
            <th class="w3-primary">Team ID</th>
            <td><?=$team->id?></td>
        </tr>
        <tr>
            <th class="w3-primary">Freilose</th>
            <td>
                <?=$team->get_freilose()?>
                <?php if($team->schiri_freilos_erhalten()){ ?>
                    <span class="w3-text-green">
                        <?= Html::icon("check") ?>
                        (Schirifreilos erhalten am <?= $team->get_schiri_freilos() ?>)
                    </span>
                <?php } //end if ?>
            </td>
        </tr>
        <tr>
            <th class="w3-primary">Ligavertreter</th>
            <td><?=$team->get_ligavertreter()?></td>
        </tr>
        <tr>
            <th class="w3-primary" style="width: 140px">PLZ</th>
            <td><?=$team->get_plz()?></td>
        </tr>
        <tr>
            <th class="w3-primary">Ort</th>
            <td><?=$team->get_ort()?></td>
        </tr>
        <tr>
            <th class="w3-primary">Verein</th>
            <td><?=$team->get_verein()?></td>
        </tr>
        <tr>
            <th class="w3-primary">Homepage</th>
            <td><?=Html::link($team->get_homepage(),extern: true)?></td>
        </tr>
    </table>
</div>

<h2 class="w3-text-primary"><?= Html::icon("mail", tag: "h2") ?> Kontaktdaten</h2>
<div class="w3-responsive w3-card-4">
    <table class="w3-table w3-striped">
        <tr>
            <th class="w3-primary">Email</th>
            <th class="w3-primary w3-center">Auf Webseite anzeigen?</th>
            <th class="w3-primary w3-center">Infomails erhalten?</th>
        </tr>
        <?php foreach($emails as $email){?>
            <tr>
                <td><?=$email['email']?></td>
                <td class='w3-center'><?=$email['public']?></td>
                <td class='w3-center'><?=$email['get_info_mail']?></td>
            </tr>
        <?php }?>
    </table>
</div>

<!-- Link Teamdaten ändern -->
<p>
    <a href="<?= $team->get_link_teamdaten_aendern()?>"
       class="w3-button w3-block w3-secondary">
        <?= Html::icon("create") ?> Team- und Kontaktdaten ändern
    </a>
</p>
