<?php

namespace LurdesBot\Music\Youtube\Commands;

use LurdesBot\Discord\DiscordCommand;
use LurdesBot\Music\Youtube\Entity\Playlist;

class MyPlaylistsCommand extends DiscordCommand {

    public function execute($params) {
        $playlists = Playlist::where('discordUserId', $this->message->author->id)
            ->orderBy('created_at', 'ASC')
            ->get();

        if (count($playlists) == 0) {
            $this->message->reply('Você ainda não tem nenhuma playlist, crie uma usando o comando `@newlist {nome da playlist}` ');
            return;
        }

        $lines = "```markdown\n💿 " . $this->message->author->username . "'s Playlists 📀";

        $listNumber = 1;

        foreach ($playlists as $playlist) {
            $using = ($playlist->using) ? ('✅') : ('  ');
            $lines .= "\n\n {$using}  {$listNumber}. {$playlist->name}";
            $listNumber++;
        }

        $lines .= "```\n O comando `@playlist {codigo da playlist}` coloca as musicas na fila de musicas, e `@playlistskip {codigo da playlist}` coloca sua lista no lugar da atual.";

        $this->message->channel->sendMessage($lines);
    }

}