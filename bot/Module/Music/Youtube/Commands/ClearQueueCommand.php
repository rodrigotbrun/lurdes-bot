<?php

namespace LurdesBot\Music\Youtube\Commands;

use LurdesBot\Discord\DiscordCommand;
use LurdesBot\Music\Youtube\Entity\Playlist;
use LurdesBot\Music\Youtube\Entity\QueueItem;

class ClearQueueCommand extends DiscordCommand {

    public function execute($params) {
        QueueItem::truncate();
        $this->message->channel->sendMessage("🙁 Musicas removidas da fila para tocar");
    }

}