<?php

namespace LurdesBot\Music\Youtube\Commands;

use Discord\Voice\VoiceClient;
use LurdesBot\Discord\DiscordCommand;

class PauseCommand extends DiscordCommand {

    public function execute($params) {
        $this->discord->getVoiceClient($this->message->channel->guild->id)->then(function (VoiceClient $voiceClient) {
            $voiceClient->pause();
        });
    }

}