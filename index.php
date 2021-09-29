<?php

date_default_timezone_set('Europe/Berlin');

const TPL = __DIR__ . '/src/tpl/';
const PHP = __DIR__ . '/src/php/';

include_once __DIR__ . '/src/classes/User.php';
$user = new User();
include_once PHP . 'code.inc.php';

include TPL . 'head.tpl.php';
include TPL . 'hamburgerMenu.tpl.php';
include TPL . 'userTable.tpl.php';
include TPL . 'forms.tpl.php';
include TPL . 'editUser.tpl.php';
include TPL . 'userInfo.tpl.php';