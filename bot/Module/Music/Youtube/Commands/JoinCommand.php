<?php

namespace LurdesBot\Music\Youtube\Commands;

use Discord\Voice\VoiceClient;
use LurdesBot\Discord\DiscordAPI;
use LurdesBot\Discord\DiscordCommand;
use LurdesBot\Discord\Entity\DiscordGuild;
use LurdesBot\Music\Youtube\Entity\MusicDJ;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class JoinCommand extends DiscordCommand {

    public function execute($params) {
        $voiceChannel = $this->userCurrentVoiceChannel();

        if (empty($voiceChannel)) {
            $this->message->channel->sendMessage('‼️🎧‼️ Sem tuts tuts? Você precisa entrar em um canal de voz para invocar a DJ Lurdes!');
            return;
        }

        $guild = DiscordGuild::saveGuild($this->message->channel->guild);
        $dj = MusicDJ::getGuildDJTable($guild);

        $dj->discordVoiceChannelId = $voiceChannel->id;
        $dj->discordTextChannelId = $this->message->channel->id;
        $dj->discordUserId = $this->message->author->id;
        $dj->bitrate = $voiceChannel->bitrate;
        $dj->djStatus = MusicDJ::STATUS_PAUSED;
        $dj->currentTrack = null;
        $dj->currentPlaylist = null;
        $saved = $dj->save();

        if ($saved) {
            $logger = new Logger('discordvc_' . $voiceChannel->id);
            $file_handler = new StreamHandler(base_path('storage/logs/d-voice-channel-' . $voiceChannel->id . '.log'));
            $logger->pushHandler($file_handler);

            // finally Join bot
            $this->discord->joinVoiceChannel($voiceChannel, true, true, $logger)->then(function (VoiceClient $voiceClient) {
                DiscordAPI::setVoiceClient($voiceClient);

                // TODO !!!!!!!!!!!!

            }, function ($e) {
                $this->message->reply('💢 🔥 ERRO! DJ lurdes: ' . $e->getMessage() . ' 🔥 💢');
            });
        }
    }

}