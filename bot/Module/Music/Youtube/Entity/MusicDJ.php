<?php

namespace LurdesBot\Music\Youtube\Entity;

use Illuminate\Database\Eloquent\Model;
use LurdesBot\Discord\Entity\DiscordGuild;

class MusicDJ extends Model {

    const STATUS_PAUSED = 'PAUSED';
    const STATUS_PLAYING = 'PLAYING';
    const STATUS_FINISHED = 'FINISHED';

    protected $table = 'musics_djs';

    public static function getGuildDJTable(DiscordGuild $guild) {
        $dj = MusicDJ::where('discordGuildId', $guild->id)->first();
        if (empty($dj)) {
            $dj = new MusicDJ();
            $dj->discordGuildId = $guild->id;
            $dj->djStatus = self::STATUS_PAUSED;
        }

        return $dj;
    }

}