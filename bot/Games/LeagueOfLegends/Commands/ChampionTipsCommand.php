<?php

namespace LurdesBot\Games\LeagueOfLegends\Commands;

use LurdesBot\Discord\DiscordCommand;
use LurdesBot\Discord\Entity\DiscordUser;
use LurdesBot\Games\LeagueOfLegends\Entity\Champion;
use LurdesBot\Games\LeagueOfLegends\Entity\ChampionTip;
use LurdesBot\Games\LeagueOfLegends\RiotApi;

class ChampionTipsCommand extends DiscordCommand {

    public function execute($params) {
        $champName = $this->message->content;
        $champion = Champion::whereName($champName)->orWhere('champ_key', $champName)->first();
        $champName = $champion->name;

        if (empty($champion)) {
            $this->message->reply('😔 Mim não achar ' . $this->message->content);
            return;
        }

        $tips = [
            ALLY_TEAM => ChampionTip::whereForTeam('A')->whereChampion($champion->id)->get(),
            ENEMY_TEAM => ChampionTip::whereForTeam('E')->whereChampion($champion->id)->get(),
        ];

        $playingWith = '';
        $playingAgainst = '';

        foreach ($tips[ALLY_TEAM] as $tip) {
            $playingWith .= '- ' . $tip->tip . PHP_EOL;
        }

        foreach ($tips[ENEMY_TEAM] as $tip) {
            $playingAgainst .= '- ' . $tip->tip . PHP_EOL;
        }

        $embed = [
            "footer" => [
                "icon_url" => "",
                "text" => ""
            ],
            'author' => [
                'name' => $champName . ' ' . $champion->title,
            ],
            "fields" => [
                [
                    'name' => 'Jogando com ' . $champName,
                    'value' => $playingWith,
                    'inline' => false
                ],
                [
                    'name' => 'Jogando contra ' . $champName,
                    'value' => $playingAgainst,
                    'inline' => false
                ],
            ],
            "thumbnail" => [
                "url" => RiotApi::championIconUrl($champion->champ_key)
            ],
            "color" => COLOR_YELLOW
        ];

        $this->message->channel->sendMessage('', null, $embed);
    }

}