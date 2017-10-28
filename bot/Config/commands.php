<?php

return [
    'help' => [
        'class' => \LurdesBot\Lurdes\Commands\HelpCommand::class,
        'help' => [
            'group' => 'Lurdes',
            'description' => 'Abre este menu de ajuda'
        ]
    ],
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
    'join' => [
        'class' => \LurdesBot\Music\Youtube\Commands\JoinCommand::class,
        'help' => [
            'group' => 'Tuts Tuts',
            'description' => 'Lurdes Bot entra no canal de audio que você esta.',
        ]
    ],
    'newlist' => [
        'class' => \LurdesBot\Music\Youtube\Commands\NewPlaylistCommand::class,
        'help' => [
            'group' => 'Tuts Tuts',
            'description' => 'Cria uma playlist vazia em seu nome. (adicione musicas usando o comando `@uselist` e `@addmusic`)',
            'params' => [
                'playlistName' => 'Nome da playlist que deseja criar'
            ]
        ],
    ],
    'playlists' => [
        'class' => \LurdesBot\Music\Youtube\Commands\MyPlaylistsCommand::class,
        'help' => [
            'group' => 'Tuts Tuts',
            'description' => 'Obtem a lista de playlists que você criou e os respectivos códigos para toca-las.',
        ]
    ],
    'uselist' => [
        'class' => \LurdesBot\Music\Youtube\Commands\UsePlaylistCommand::class,
        'help' => [
            'group' => 'Tuts Tuts',
            'description' => 'Seleciona a playlist sem toca-la, para gerenciar as musicas da fila.',
            'params' => [
                'playlistCode' => 'Código da sua playlist (descubra qual chamando @playlists)'
            ]
        ]
    ],
    'playlist' => [
        'class' => \LurdesBot\Music\Youtube\Commands\AddPlaylistToQueueCommand::class,
        'help' => [
            'group' => 'Tuts Tuts',
            'description' => 'Adiciona as musicas da playlist na fila de musicas para tocar.',
            'params' => [
                'playlistCode' => 'Código da sua playlist (descubra qual chamando @playlists)'
            ]
        ]
    ],
    'playlistskip' => [
        'class' => \LurdesBot\Music\Youtube\Commands\SkipToPlaylistToQueueCommand::class,
        'help' => [
            'group' => 'Tuts Tuts',
            'description' => 'Limpa a fila de musicas atual, e começa a tocar a playlist desejada.',
            'params' => [
                'playlistCode' => 'Código da sua playlist (descubra qual chamando @playlists)'
            ]
        ]
    ],
    'addmusic' => [
        'class' => \LurdesBot\Music\Youtube\Commands\AddMusicToPlaylistCommand::class,
        'help' => [
            'group' => 'Tuts Tuts',
            'description' => 'Adicionar uma musica para a playlist em uso (vide `@uselist`). ',
            'params' => [
                'youtubeUrl' => 'URL para a música no youtube'
            ]
        ]
    ],
    'delmusic' => [
        'class' => \LurdesBot\Music\Youtube\Commands\DeleteMusicFromPlaylistCommand::class,
        'help' => [
            'group' => 'Tuts Tuts',
            'description' => 'Remove uma musica da playlist em uso (vide `@uselist`). ',
            'params' => [
                'playlistCode' => 'Código da sua playlist (descubra qual chamando @playlists)'
            ]
        ]
    ],
    'loopqueue' => [
        'class' => \LurdesBot\Music\Youtube\Commands\LoopPlaylistCommand::class,
        'help' => [
            'group' => 'Tuts Tuts',
            'description' => 'Executa infinitamente, sem parar, contínuamente a fila de músicas (com todas as musicas, de todas as playlists que foram adicionadas chamando `@playlist {playlistCode}`)',
        ]
    ],
    'queue' => [
        'class' => \LurdesBot\Music\Youtube\Commands\ListQueueCommand::class,
        'help' => [
            'group' => 'Tuts Tuts',
            'description' => 'Retorna a lista de musicas para tocar (para o canal de audio em que a DJ Lurdes esta)',
        ]
    ],
    'search' => [
        'class' => \LurdesBot\Music\Youtube\Commands\SearchMusicCommand::class,
        'help' => [
            'group' => 'Tuts Tuts',
            'description' => 'Retona resultados de busca do youtube para a sua consulta.',
        ]
    ],
    'play' => [
        'class' => \LurdesBot\Music\Youtube\Commands\PlayCommand::class,
        'help' => [
            'group' => 'Tuts Tuts',
            'description' => 'Adiciona uma música na fila para tocar ou toca imediatamente se a fila etiver vazia',
        ]
    ],
    'pause' => [
        'class' => \LurdesBot\Music\Youtube\Commands\PauseCommand::class,
        'help' => [
            'group' => 'Tuts Tuts',
            'description' => 'Pausa a musica atual!',
        ]
    ],
    'next' => [
        'class' => \LurdesBot\Music\Youtube\Commands\NextCommand::class,
        'help' => [
            'group' => 'Tuts Tuts',
            'description' => 'Passa para a próxima musica da fila!',
        ]
    ],
    'clear' => [
        'class' => \LurdesBot\Music\Youtube\Commands\ClearQueueCommand::class,
        'help' => [
            'group' => 'Tuts Tuts',
            'description' => 'Limpa as músicas da fila para tocar (não para a musica atual)',
        ]
    ],
];