<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => getenv('DB_HOST'),
    'database' => getenv('DB_DATABASE'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASSWORD'),
    'port' => getenv('DB_PORT'),
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

define('CONFIG', \Entity\Config::getConfig());

require_once __DIR__ . '/bot/colors.php';

function base_path($file) {
    return __DIR__ . '/' . $file;
}

$dataLanguage = file_get_contents(__DIR__ . '/bot/Games/LeagueOfLegends/Generators/assets/language-strings.json');
$dataLanguage = json_decode($dataLanguage, true);

function lang($key) {
    global $dataLanguage;
    if (isset($dataLanguage['data'][$key]))
        return $dataLanguage['data'][$key];
    return $key;
}
