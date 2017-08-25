<?php

namespace LurdesBot\Music\Youtube\Commands;

use LurdesBot\Discord\DiscordCommand;
use LurdesBot\Music\Youtube\Entity\Playlist;

class AddPlaylistToQueueCommand extends UsePlaylistCommand {

    public function execute($params) {
        parent::execute($params);

        // TODO - ADICIONAR MUSICAS NA FILA
    }

}