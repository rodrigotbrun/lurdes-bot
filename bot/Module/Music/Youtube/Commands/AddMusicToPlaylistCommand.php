<?php

namespace LurdesBot\Music\Youtube\Commands;

use LurdesBot\Discord\DiscordCommand;
use LurdesBot\Music\Youtube\Entity\Playlist;
use LurdesBot\Music\Youtube\Entity\Track;

class AddMusicToPlaylistCommand extends DiscordCommand {

    public function execute($params) {
        $url = $this->message->content;
        $playlist = Playlist::playlistInUse($this->message->author->id);
        $track = Track::addMusic($url, $playlist);

        if ($track instanceof Track) {
            $this->message->channel->sendMessage('✅ "' . $track->name . '" adicionado na playlist "' . $playlist->name . '"');
        } else {
            if ($track == Track::TRACK_NOT_ADDED_TO_PLAYLIST) {
                $this->message->reply('💢 Não consegui adicionar esta musica na playlist!');
            } else if ($track == Track::TRACK_ALREADY_EXISTS_ON_PLAYLIST) {
                $this->message->reply('💬 Esta musica ja esta na sua playlist "' . $playlist->name . '"');
            } else if ($track == Track::INVALID_TRACK_URL) {
                $this->message->reply('💢 URL do youtube inválida 💢');
            }
        }
    }

}