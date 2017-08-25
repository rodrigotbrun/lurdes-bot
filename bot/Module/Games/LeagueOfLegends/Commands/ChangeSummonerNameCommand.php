<?php

namespace LurdesBot\Games\LeagueOfLegends\Commands;

use LurdesBot\Discord\DiscordCommand;
use LurdesBot\Discord\Entity\DiscordUser;
use LurdesBot\Games\LeagueOfLegends\RiotApi;

class ChangeSummonerNameCommand extends DiscordCommand {

    public function execute($params) {
        $discordUser = DiscordUser::find($this->message->author->id);
        $summoner = RiotApi::summonerInfo($this->message->content);

        if (empty($discordUser)) {
            $discordUser = new DiscordUser();
            $discordUser->id = $this->message->author->id;
            $discordUser->lolSummonerName = $summoner->nickname;
            $discordUser->saveOrFail();
        } else {
            $discordUser->lolSummonerName = $summoner->nickname;
            $discordUser->saveOrFail();
        }

        $this->message->channel->sendMessage('👍🏽 O nick de "' . $this->message->author->user->username . '" no lolzin agora é "' . $this->message->content . '"');
    }

}