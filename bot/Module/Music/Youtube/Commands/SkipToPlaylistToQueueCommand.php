<?php

namespace LurdesBot\Music\Youtube\Commands;

use LurdesBot\Discord\DiscordCommand;
use LurdesBot\Music\Youtube\Entity\Playlist;

class SkipToPlaylistToQueueCommand extends AddPlaylistToQueueCommand {

    public function execute($params) {
        // TODO - LIMPAR A LISTA PRIMEIRO E CONTINUAR COM O ADICIONAR.

        parent::execute($params);
    }

}