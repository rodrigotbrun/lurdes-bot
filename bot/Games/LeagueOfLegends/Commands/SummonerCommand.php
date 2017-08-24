<?php

namespace LurdesBot\Games\LeagueOfLegends\Commands;

use LurdesBot\Discord\DiscordCommand;
use LurdesBot\Discord\Entity\DiscordUser;
use LurdesBot\Games\LeagueOfLegends\RiotApi;

class SummonerCommand extends DiscordCommand {

    public function execute($params) {
        $discordUser = DiscordUser::find($this->message->author->id);
        if (empty($discordUser)) {
            $this->message->reply(
                "😑 " . $this->message->author->user->username . " você ainda não me disse qual seu nick no lol." .
                PHP_EOL .
                "ℹ️ Envie \"" . CONFIG['discord_command_identifier'] . "setsummoner MeuNomeNoLol\" para associar sua conta discord com sua conta do lol! "
            );
        } else {
            $summoner = RiotApi::summonerInfo($discordUser->lolSummonerName);

            $embed = [
                "footer" => [
                    "icon_url" => "",
                    "text" => ""
                ],
                'author' => [
                    'name' => $summoner->nickname,
                    'url' => 'https://br.op.gg/summoner/userName=' . $summoner['nickname'],
                    'icon_url' => RiotApi::summonerIconUrl($summoner->profile_icon_id),
                ],
                "fields" => [],
                "thumbnail" => [
                    "url" => ""
                ],
                "color" => COLOR_GREEN
            ];

            $this->message->channel->sendMessage("😎 {$this->message->author->user->username} no lol é \"" . $summoner->nickname . "\"", null, $embed);
        }
    }

}