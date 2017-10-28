<?php

namespace LurdesBot\Music\Youtube\Commands;

use Discord\Voice\VoiceClient;
use LurdesBot\Discord\DiscordCommand;
use LurdesBot\Music\Youtube\Entity\QueueItem;
use LurdesBot\Music\Youtube\Entity\Track;

class PlayCommand extends DiscordCommand {

    public function execute($params) {
        require_once __DIR__ . '/../lib-download/yt_downloader.php';

        $voiceChannel = $this->userCurrentVoiceChannel();

        if (empty($voiceChannel)) {
            $this->message->channel->sendMessage('‼️🎧‼️ Sem tuts tuts? Você precisa entrar em um canal de voz para invocar a DJ Lurdes!');
            return;
        }

        $this->discord->getVoiceClient($voiceChannel->id)->then(function (VoiceClient $voiceClient) {
            $voiceClient->stop();
        });

        $this->message->channel->sendMessage('✅ Tocando... `@queue` para ver as próximas musicas');

        $voiceClient = $this->discord->getVoiceClient($this->message->channel->guild->id);

        if (empty(trim($this->message->content))) {
            $voiceClient->then(function (VoiceClient $voiceClient) {
                $item = QueueItem::orderBy('created_at', 'ASC')->first();
                $next = $item->track()->first();

                echo "Next queue item id --> " . $next->id, PHP_EOL;

                if (!file_exists(storage_path('audio/' . $next->youtube_id . '.mp3')))
                    $this->message->reply("⤵️💾 Baixando música... Ja vou toca-la!");

                if (!empty($next)) {
                    $this->playTrack($next, $voiceClient);
                }

            }, function ($e) {
                $this->message->reply($e->getMessage());
            });

        } else {
            $track = Track::createTrack($this->message->content);
            QueueItem::addTrack($voiceChannel->id, $track);

            if (!file_exists(storage_path('audio/' . $track->youtube_id . '.mp3')))
                $this->message->reply("⤵️💾 Baixando música... Ja vou toca-la!");

            $voiceClient->then(function (VoiceClient $voiceClient) use ($track) {
                $this->playTrack($track, $voiceClient);
            });
        }
    }

    private function playTrack(Track $track = null, VoiceClient $voiceClient) {
        if (empty($track)) {
            $this->message->channel->sendMessage("Sem mais músicas para tocar! Faloooow");
            $voiceClient->close();
        } else {
            $localFile = storage_path('audio/' . $track->youtube_id . '.mp3');

            if (!file_exists($localFile)) {

                try {
                    shell_exec('cd "' . storage_path('audio/') . '";youtube-dl ' . $track->youtube_id . ' --extract-audio --audio-format mp3 --id --no-playlist;cd -');
                    $localFile = storage_path('audio/' . $track->youtube_id . '.mp3');
                    $this->message->reply("👍 Pronto! Vou botar pra tocar...");
                } catch (\Exception $e) {
                    $this->message->reply($e->getMessage());
                }
            }

//            $voiceClient->stop()->then(function (VoiceClient $voiceClient) use ($localFile) {
            $voiceClient->playFile($localFile)->then(function (VoiceClient $voiceClient) {
                $nextCmd = new NextCommand($this->message, $this->discord);
                $nextCmd->execute([
                    'dontStop' => true
                ]);
            });
//            });
        }
    }

}