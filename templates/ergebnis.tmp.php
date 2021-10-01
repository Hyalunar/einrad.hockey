<section class="w3-section" id="<?= $this->turnier_id ?>">
    <h3>
        <?= date("d.m.Y", strtotime($this->datum)) ?>
        <span class="w3-text-primary"><?= $this->ort ?></span>
        <i>(<?= $this->tblock ?>)</i>
        <br>
        <span class="<?= ($this->art == 'final') ? "w3-text-secondary" : "w3-text-grey" ?>">
            <?= $this->tname ?? '' ?>
        </span>
    </h3>
    <div class="w3-responsive w3-card-4">
        <table class="w3-table w3-centered w3-striped w3-leftbar w3-border-tertiary">
            <tr class="w3-primary">
                <th>
                    <?= Html::icon("bar_chart") ?>
                    <br>Platz
                </th>
                <th>
                    <?= Html::icon("group") ?>
                    <br>Team
                </th>
                <th class="w3-center">
                    <?= Html::icon("emoji_events") ?>
                    <br>Punkte
                </th>
            </tr>
            <?php foreach ($this->ergebnisse as $key => $ergebnis): ?>
                <tr class="<?= $color[$key] ?? '' ?>">
                    <td><?= $ergebnis['platz'] ?></td>
                    <td style="white-space: nowrap"><?= $ergebnis['teamname'] ?></td>
                    <td><?= $ergebnis['ergebnis'] ?: '-' ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <p>
        <?= Html::link('archiv_turnier.php?turnier_id=' . $this->turnier_id, 'Spielergebnisse', icon: 'info') ?>
    </p>
</section>