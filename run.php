<?php

require_once __DIR__ . '/bootstrap.php';

$discordLoop = new \LurdesBot\Discord\DiscordBotLoop();
$discordLoop->loop();

