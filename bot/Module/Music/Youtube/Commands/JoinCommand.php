<?php

namespace LurdesBot\Music\Youtube\Commands;

use Discord\Voice\VoiceClient;
use LurdesBot\Discord\DiscordAPI;
use LurdesBot\Discord\DiscordCommand;
use LurdesBot\Discord\Entity\DiscordGuild;
use LurdesBot\Music\Youtube\Entity\MusicDJ;
use LurdesBot\Music\Youtube\Entity\Playlist;
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

        $playlist = Playlist::playlistInUse($this->message->author->id);
        if (!empty($playlist)) {
            $dj->currentPlaylist = $playlist->id;
        } else {
            $dj->currentPlaylist = null;
        }

        $saved = $dj->save();

        if ($saved) {
            $logger = new Logger('discordvc_' . $voiceChannel->id);
            $file_handler = new StreamHandler(base_path('storage/logs/d-voice-channel-' . $voiceChannel->id . '.log'));
            $logger->pushHandler($file_handler);

            $this->discord->joinVoiceChannel($voiceChannel, false, true, $logger)->then(function (VoiceClient $voiceClient) {
                DiscordAPI::setVoiceClient($voiceClient);

                $this->message->channel->sendMessage("Eai pessoal! Lurdes na area!");
                $voiceClient->playFile(storage_path('static-audio/join.mp3'))->then(function ($kind) {
                }, function ($e) {
                    $this->message->reply('💢 🔥 ERRO! DJ lurdes: ' . $e->getMessage() . ' 🔥 💢');
                });

            }, function ($e) {
                $this->message->reply('💢 🔥 ERRO! DJ lurdes: ' . $e->getMessage() . ' 🔥 💢');
            });
        }
    }

}