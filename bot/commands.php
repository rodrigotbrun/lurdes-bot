<?php

return [
    'lolv' => [
        'class' => \LurdesBot\Games\LeagueOfLegends\Commands\VersionCommand::class,
        'help' => [
            'group' => 'League of Legends',
            'description' => 'Retorna a versão do lol que o Lurdes Bot esta usando para integração'
        ]
    ],
    'gg' => [
        'class' => \LurdesBot\Games\LeagueOfLegends\Commands\GGCommand::class,
        'help' => [
            'group' => 'League of Legends',
            'description' => 'Retorna informações da partida atual em que você esta (pode ser chamado assim que a tela de carregamento do lol abrir)'
        ]
    ],
    'summoner' => [
        'group' => 'League of Legends',
        'class' => \LurdesBot\Games\LeagueOfLegends\Commands\SummonerCommand::class,
        'help' => [
            'group' => 'League of Legends',
            'description' => 'Retorna qual nome de invocador esta associado com sua conta do discord'
        ]
    ],
    'setsummoner' => [
        'class' => \LurdesBot\Games\LeagueOfLegends\Commands\ChangeSummonerNameCommand::class,
        'help' => [
            'group' => 'League of Legends',
            'description' => 'Salva seu nome de invocador no lol com sua conta discord (necessário para todos comandos referentes ao lol)',
            'params' => [
                'summonerName' => 'Seu nome de invocador no lol'
            ]
        ]
    ],
    'loltips' => [
        'class' => \LurdesBot\Games\LeagueOfLegends\Commands\ChampionTipsCommand::class,
        'help' => [
            'group' => 'League of Legends',
            'description' => 'Retorna dicas para jogar com ou contra um determinado campeão.',
            'params' => [
                'championName' => 'Nome de um campeão no lol'
            ]
        ]
    ],
];