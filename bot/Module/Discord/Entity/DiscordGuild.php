<?php

namespace LurdesBot\Discord\Entity;

use Discord\Parts\Guild\Guild;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string id
 */
class DiscordGuild extends Model {

    protected $table = 'discord_guilds';

    public static function saveGuild(Guild $guild) {
        $g = DiscordGuild::find($guild->id);

        if (empty($g)) {
            $g = new DiscordGuild();
            $g->id = $guild->id;
        }

        $g->name = $guild->name;
        $g->ownerId = $guild->owner_id;
        $g->icon = $guild->icon;
        $g->member_count = $guild->member_count;
        $g->save();

        return $g;
    }

}