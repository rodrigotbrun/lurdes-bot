<?php

namespace LurdesBot\Music\Youtube\Commands;

use Illuminate\Support\Facades\DB;
use LurdesBot\Discord\DiscordCommand;
use LurdesBot\Music\Youtube\Entity\Playlist;

class NewPlaylistCommand extends DiscordCommand {

    public function execute($params) {
        $playlistName = $this->message->content;
        $playlistName = trim($playlistName);

        if (empty($playlistName)) {
            $this->message->reply(' por favor, me diga o nome da playlist junto com o comando! 🙏  ( @newlist {nome da playlist} )');
            return;
        }

        $nameNotInUse = Playlist::where('discordUserId', $this->message->author->id)
                ->where('name', $playlistName)
                ->count() == 0;

        if ($nameNotInUse) {
            $plId = Playlist::where('discordUserId', $this->message->author->id)->count() + 1;

            $playlist = new Playlist();
            $playlist->name = $playlistName;
            $playlist->discordUserId = $this->message->author->id;
            $playlist->code = $plId;
            $playlist->using = true;

            if ($playlist->save()) {
                Playlist::usePlaylist($this->message->author->id, $plId);
                $this->message->reply('👏 Playlist criada ( coloque-a na fila para tocar usando "@playlist ' . $plId . '" ou "@playlistskip ' . $plId . '" para começar imediatamente) 👏');
            } else {
                $this->message->reply('😱 Não estou conseguindo criar sua playlist... teeeeeeente outra veeezzz!!!');
            }
        } else {
            $this->message->reply('Você ja tem uma playlist com este nome "' . $playlistName . '". ( para ver suas playlists chame o comando @playlists )');
            return;
        }
    }

}