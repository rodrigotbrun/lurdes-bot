<?php

namespace LurdesBot\Music\Youtube\Commands;

use LurdesBot\Discord\DiscordCommand;
use LurdesBot\Music\Youtube\Entity\MusicDJ;
use LurdesBot\Music\Youtube\Entity\QueueItem;

class ListQueueCommand extends DiscordCommand {

    public function execute($params) {
        $voiceChannel = $this->userCurrentVoiceChannel();
        $this->logger->debug('Getting current voice channel');
        $this->logger->debug('Voice channel', [$voiceChannel]);

        if (empty($voiceChannel)) {
            $this->message->channel->sendMessage('‼️🎧‼️ Sem tuts tuts? Você precisa entrar em um canal de voz para invocar a DJ Lurdes!');
            return;
        }

        $dj = MusicDJ::where('discordVoiceChannelId', $voiceChannel->id)
            ->first();

        $this->logger->debug('DJ', [$dj]);

        if (empty($dj)) {
            $this->message->channel->sendMessage('Chame a DJ Lurdes para um canal de voz primeiro, usando o comando `' . CONFIG['discord_command_identifier'] . '`join');
            return;
        }

        $queue = QueueItem::where('discordChannelId', $voiceChannel->id)
            ->get();

        $this->logger->debug('Queue Items', [$queue]);

        if (count($queue) == 0) {
            $this->message->reply('Nenhuma musica na fila para tocar!');
            return;
        }

        $lines = "```markdown\n💿 Musicas na fila para tocar - DJ Lurdes 📀";

        foreach ($queue as $index => $item) {
            $current = ($dj->currentTrack == $item->id) ? ('🔊') : ('  ');
            $track = $item->track()->first();
            $t = new \DateInterval($track->duration);

            $hours = str_pad($t->h, '2', '0', STR_PAD_LEFT);
            $minutes = str_pad($t->i, '2', '0', STR_PAD_LEFT);
            $seconds = str_pad($t->s, '2', '0', STR_PAD_LEFT);

            $time = "{$hours}:{$minutes}:{$seconds}";
            $number = $index + 1;
            $lines .= "\n\n {$current}  {$number}. [{$time}] {$track->name}";
        }

        $this->message->channel->sendMessage($lines . "\n```");
    }

}