<?php

require_once 'config/init.conf.php';

setcookie('sid','', -1);

$_SESSION['notification']['result'] = 'danger';
$_SESSION['notification']['message'] = 'Vous êtes déconnecté';

header("Location: index.php");