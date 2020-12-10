<?php
ini_set('display_errors', 'On');

require __DIR__ . '/vendor/autoload.php';

use App\App;

$conf = App::init();

define('BASE', $conf['web']);
define('ROOT', $conf['root']);
define('DSN', $conf['driver'] . ':host=' . $conf['dbhost'] . ';dbname=' . $conf['dbname']);
define('USR', $conf['dbuser']);
define('PWD', $conf['dbpass']);

App::run();
