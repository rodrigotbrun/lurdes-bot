<?php

namespace LurdesBot\Music\Youtube\Commands;

use LurdesBot\Discord\DiscordCommand;
use LurdesBot\Music\Youtube\Entity\Playlist;

class UsePlaylistCommand extends DiscordCommand {

    public function execute($params) {
        $usePlaylist = Playlist::usePlaylist($this->message->author->id, $params[0]);

        if (empty($usePlaylist)) {
            $this->message->reply('Não existe nenhuma playlist com este código, chame @playlists para ver as que estão disponíveis.');
            return;
        }

        $this->message->channel->sendMessage('✅ Usando playlist codigo ' . $usePlaylist->code . ' (' . $usePlaylist->name . '). Adicionar musicas usando `@addmusic` irá colocar nesta lista!');
    }

}