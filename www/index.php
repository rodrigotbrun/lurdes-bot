<?php

use LurdesBot\WebControl\Builder\WebControlBuilder;

require_once __DIR__ . '/../bootstrap.php';

$app = new WebControlBuilder();
$app->registerRoutes();
$app->run();