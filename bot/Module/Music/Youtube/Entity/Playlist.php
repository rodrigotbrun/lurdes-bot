<?php

namespace LurdesBot\Music\Youtube\Entity;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model {

    protected $table = 'musics_playlists';

    public static function usePlaylist($discordUserId, $code) {
        $all = Playlist::where('discordUserId', $discordUserId)->get();
        $pl = null;
        $contains = false;
        foreach ($all as $a) {
            if ($a->code == $code) {
                $contains = true;
                break;
            }
        }

        if ($contains) {
            foreach ($all as $a) {
                $using = ($a->code == $code);
                $a->using = $using;
                $a->save();

                if ($using) $pl = $a;
            }
        }

        return $pl;
    }

    public static function playlistInUse($discordUserId) {
        $f = Playlist::where('discordUserId', $discordUserId)
            ->where('using', '1')
            ->first();

        return $f;
    }

    public function tracks() {
        return $this->hasMany(Track::class, 'playlist', 'id');
    }

}