<?php

namespace LurdesBot\Music\Youtube\Commands;

use LurdesBot\Discord\DiscordCommand;
use LurdesBot\Music\Youtube\Entity\Playlist;
use LurdesBot\Music\Youtube\Entity\QueueItem;
use LurdesBot\Music\Youtube\Entity\Track;
use LurdesBot\Music\Youtube\YoutubeAPI;

class PlayCommand extends DiscordCommand {

    public function execute($params) {
        parent::execute($params);
        var_dump(3333);
        $voiceChannel = $this->userCurrentVoiceChannel();
        var_dump(222);

        if (empty($voiceChannel)) {
            $this->message->channel->sendMessage('‼️🎧‼️ Sem tuts tuts? Você precisa entrar em um canal de voz para invocar a DJ Lurdes!');
            return;
        }

        var_dump(111);
        $track = Track::createTrack($this->message->content);
        var_dump($track);
        QueueItem::addTrack($voiceChannel->id, $track);

        $this->message->channel->sendMessage('✅ 1 musica adicionada na fila para tocar');
    }

}