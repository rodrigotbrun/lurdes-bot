<?php

namespace LurdesBot\Music\Youtube\Entity;

use Illuminate\Database\Eloquent\Model;
use LurdesBot\Music\Youtube\YoutubeAPI;

class Track extends Model {

    const TRACK_ADDED_TO_PLAYLIST = -3;
    const TRACK_NOT_ADDED_TO_PLAYLIST = -1;
    const TRACK_ALREADY_EXISTS_ON_PLAYLIST = -2;
    const INVALID_TRACK_URL = -4;

    protected $table = 'musics_playlists_tracks';

    public static $youtubeApi = null;

    public function getNameAttribute() {
        return base64_decode($this->attributes['name']);
    }

    public function setNameAttribute($name) {
        $this->attributes['name'] = base64_encode($name);
    }

    public static function addMusic($url, Playlist $playlist) {
        $videoId = YoutubeAPI::videoIdFromUrl($url);

        if (self::$youtubeApi === null)
            self::$youtubeApi = new YoutubeAPI();

        $videoInfo = self::$youtubeApi->getVideoInfo($videoId);

        if (empty($videoId))
            return self::INVALID_TRACK_URL;

        $track = Track::where('youtube_id', $videoId)
            ->where('playlist', $playlist->id)
            ->first();

        if (empty($track)) {
            $track = new Track();
            $track->playlist = $playlist->id;
            $track->youtube_id = $videoId;
            $track->name = $videoInfo->snippet->localized->title;
            $track->duration = $videoInfo->contentDetails->duration;
            $s = $track->saveOrFail();

            if ($s)
                return $track;
            return self::TRACK_NOT_ADDED_TO_PLAYLIST;
        }
        return self::TRACK_ALREADY_EXISTS_ON_PLAYLIST;
    }

}