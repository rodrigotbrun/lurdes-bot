<?php

namespace LurdesBot\Music\Youtube\Commands;

use Discord\Voice\VoiceClient;
use LurdesBot\Discord\DiscordCommand;
use LurdesBot\Music\Youtube\Entity\QueueItem;

class NextCommand extends DiscordCommand {

    public function execute($params) {
        $this->discord->getVoiceClient($this->message->channel->guild->id)->then(function (VoiceClient $voiceClient) use ($params) {
            $f = function () use ($params) {
                QueueItem::orderBy('created_at', 'ASC')->first()->delete();
                $this->message->content = '';

                if (QueueItem::count() > 0) {
                    $playCommandForNext = new PlayCommand($this->message, $this->discord);
                    $playCommandForNext->execute($params);
                } else {
                    $this->message->reply("Não tem mais musicas na fila! :(");
                }
            };

            if(isset($params['dontStop'])){
                $f();
            }else{
                $voiceClient->stop()->then($f);
            }
        });
    }

}