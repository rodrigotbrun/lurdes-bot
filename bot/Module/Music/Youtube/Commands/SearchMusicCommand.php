<?php

namespace LurdesBot\Music\Youtube\Commands;

use LurdesBot\Discord\DiscordCommand;
use LurdesBot\Discord\Entity\DiscordUser;
use LurdesBot\Music\Youtube\Entity\Playlist;
use LurdesBot\Music\Youtube\YoutubeAPI;

class SearchMusicCommand extends DiscordCommand {

    public function execute($params) {
        $youtubeApi = new YoutubeAPI();
        $searchResult = $youtubeApi->search($this->message->content, 10);

        $lines = "```markdown\n🕵 Resultados para sua busca " . '"' . $this->message->content . '"';

        foreach ($searchResult as $i => $r) {
            $n = $i + 1;
            $lines .= "\n\n  {$n}. {$r->snippet->title}";
        }

        $this->message->channel->sendMessage($lines . "\n```\n 📩 Responda com o número do vídeo que deseja adicionar na fila para tocar!");

        $this->waitOptionChoose($this->message->author->id, __CLASS__, $searchResult,
            function ($data, $position, $discord, $message) {
                $videoId = $data[$position]->id->videoId;
                $message->content = "http://youtu.be/{$videoId}";
                $command = new PlayCommand($message, $discord);
                $command->fire([], PlayCommand::class);
            }
        );
    }

}