<section class="w3-section" id="<?= $this->turnier_id ?>"> 
        <?php if ($this->art == 'final'): ?>
            <h3>
                <span><?= date("d.m.Y", strtotime($this->datum)) ?></span>
                <span class="w3-text-secondary"><?= $this->tname ?></span>
                <span><?= $this->ort ?></span>
            </h3>
        <?php else: ?>
            <h3>
                <span><?= date("d.m.Y", strtotime($this->datum)) ?></span>
                <span class="w3-text-primary"><?= $this->ort ?></span>
                <span><?= $this->tblock ?></span>
            </h3>
        <?php endif; ?>
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