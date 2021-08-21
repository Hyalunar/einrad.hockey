<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Spieler bitte ändern.</title>
</head>
<body>
<p>Hallo Ligaausschuss,</p>

<p>Das Team <?=$this->get_team()?> hat eine Spieleränderung beantragt:</p>
<p>
    <a href="<?=Env::BASE_URL?>/ligacenter/lc_spieler_aendern.php?spieler_id=<?=$this->id()?>">
        Link: <?= $this->id() ?> | <?= $this->get_name() ?>
    </a>
</p>

<p>Zugehöriger Text:</p>
<p><?= nl2br($text) ?></p>

<p>Euer Mailbot</p>
</body>
</html>