<?php
/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LOGIK////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
require_once '../../init.php';
require_once '../../logic/session_oa.logic.php'; //Auth
require_once '../../logic/kontaktcenter.logic.php';

/////////////////////////////////////////////////////////////////////////////
////////////////////////////////////LAYOUT///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
Html::$titel = 'Kontaktcenter | Ligacenter';
include '../../templates/header.tmp.php';
include '../../templates/kontaktcenter.tmp.php';
include '../../templates/footer.tmp.php';