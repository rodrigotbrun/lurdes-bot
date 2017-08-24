<?php

use LurdesBot\Games\LeagueOfLegends\Generators\LiveGameDataImageGenerator;

require_once __DIR__ . '/bootstrap.php';

//$discordLoop = new \LurdesBot\Discord\DiscordBotLoop();
//$discordLoop->loop();
//
//
$i = new LiveGameDataImageGenerator('16315560',
    \LurdesBot\Games\LeagueOfLegends\RiotApi::liveGameData('16315560')
);

$i->buildImage();
echo $i->render();

