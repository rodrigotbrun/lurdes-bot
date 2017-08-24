<?php

namespace LurdesBot\Games\LeagueOfLegends\Commands;

use DateTime;
use DateTimeZone;
use LurdesBot\Discord\DiscordCommand;
use LurdesBot\Discord\Entity\DiscordUser;
use LurdesBot\Games\LeagueOfLegends\Generators\LiveGameDataImageGenerator;
use LurdesBot\Games\LeagueOfLegends\RiotApi;

class GGCommand extends DiscordCommand {

    public function execute($params) {
        $discordUserId = $this->message->author->user->id;
        $check = DiscordUser::find($discordUserId);

        if (empty($check)) {
            $this->message->channel->sendMessage(
                "😑 " . $this->message->author->user->username . " você ainda não me disse qual seu nick no lol." .
                PHP_EOL .
                "ℹ️ Envie \"@setSummoner MeuNomeNoLol\" para associar sua conta discord com sua conta do lol! "
            );
            return;
        }

        $this->message->reply("🔎 Aguarde... calculando informações da partida!")->then(function ($mm) use ($check) {
            $dt = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
            $summoner = RiotApi::summonerInfo($check->lolSummonerName);
            $summonerId = $summoner->id;
            $gameInfo = RiotApi::liveGameData($summoner->id);
            file_put_contents(base_path('storage/audit-data/livegame-' . time() . '.json'), json_encode($gameInfo));

            if (json_last_error() !== JSON_ERROR_NONE) {
                $mm->reply('🤕 não estou conseguindo comunicação com a api da Rito Gomes.');
                return;
            }

            if (isset($gameInfo->status)) {
                $mm->reply('🛑🛑 Você não esta em uma partida. (chame @gg quando estiver na tela de carregamento ou durante o jogo) 🛑🛑');
                return null;
            }

            $im = new LiveGameDataImageGenerator($summonerId, $gameInfo);
            $im->buildImage();
            $tempFile = $im->render();

            $mm->channel->sendFile($tempFile, 'gg-' . $summoner['id'] . '-' . time() . '.png', '')
                ->then(function () {
                    echo 'Arquivo enviado!';
                });
        });
    }

}