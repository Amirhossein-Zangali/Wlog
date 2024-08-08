<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Core/Config.php';
require_once __DIR__ . '/Core/jdf.php';
use Illuminate\Database\Capsule\Manager as Capsule;

date_default_timezone_set(TIMEZONE);

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => DB,
    'host'      => HOST,
    'database'  => DB_NAME,
    'username'  => DB_USER,
    'password'  => DB_PASS,
    'charset'   => DB_CHAR,
    'collation' => DB_COLL,
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

