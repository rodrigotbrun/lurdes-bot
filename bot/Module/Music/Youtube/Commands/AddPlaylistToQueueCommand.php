<?php

namespace LurdesBot\Music\Youtube\Commands;

use LurdesBot\Discord\DiscordCommand;
use LurdesBot\Music\Youtube\Entity\Playlist;
use LurdesBot\Music\Youtube\Entity\QueueItem;

class AddPlaylistToQueueCommand extends UsePlaylistCommand {

    public function execute($params) {
        $this->notifyUse = false;
        parent::execute($params);

        $playlist = Playlist::playlistInUse($this->message->author->id);
        $tracks = $playlist->tracks()->get();
        $voiceChannel = $this->userCurrentVoiceChannel();

        if (empty($voiceChannel)) {
            $this->message->channel->sendMessage('‼️🎧‼️ Sem tuts tuts? Você precisa entrar em um canal de voz para invocar a DJ Lurdes!');
            return;
        }

        $x = count($tracks);
        if (count($x) > 0) {
            foreach ($tracks as $track) {
                QueueItem::addTrack($voiceChannel->id, $track);
            }

            if ($x != 1) {
                $this->message->channel->sendMessage('✅ ' . $x . ' musicas adicionadas na fila para tocar');
            } else {
                $this->message->channel->sendMessage('✅ ' . $x . ' musica adicionada na fila para tocar');
            }
        } else {
            $this->message->reply('⁉️ Esta playlist esta vazia, adicione musicas chamando o comando `' . CONFIG['discord_command_identifier'] . 'addmusic` para salva-las em uma playlist, ou `' . CONFIG['discord_command_identifier'] . 'play` para colocar diretamente na fila de execução');
        }

    }

}