<?php

namespace LurdesBot\Music\Youtube\Entity;

use Illuminate\Database\Eloquent\Model;

class QueueItem extends Model {

    protected $table = 'musics_queue';

    protected $with = [
        'track'
    ];

    public function track() {
        return $this->hasOne(Track::class, 'id', 'track');
    }

    public static function clear($discordChannelId) {
        $items = QueueItem::where('discordChannelId', $discordChannelId)->get();
        foreach ($items as $I) {
            $I->delete();
        }
    }

    public static function skip($discordChannelId) {
        // TODO
    }

    /**
     * @param $discordChannelId
     * @param Track $track
     * @return QueueItem
     */
    public static function addTrack($discordChannelId, Track $track) {
        $qi = new QueueItem();
        $qi->track = $track->id;
        $qi->discordChannelId = $discordChannelId;
        $qi->save();

        return $qi;
    }

}