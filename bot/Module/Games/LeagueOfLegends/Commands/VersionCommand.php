<?php

namespace LurdesBot\Games\LeagueOfLegends\Commands;

use LurdesBot\Discord\DiscordCommand;

class VersionCommand extends DiscordCommand {

    public function execute($params) {
        $version = CONFIG['lol_version'];
        $this->message->channel->sendMessage("ℹ️ Versão do lolzinho: {$version}");
    }

}