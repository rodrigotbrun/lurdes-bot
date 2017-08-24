<?php

namespace LurdesBot\Discord\Entity;

class DiscordPermission {

    const CREATE_INSTANT_INVITE = 0x00000001;
    const KICK_MEMBERS = 0x00000002;
    const BAN_MEMBERS = 0x00000004;
    const ADMINISTRATOR = 0x00000008;
    const MANAGE_CHANNELS = 0x00000010;
    const MANAGE_GUILD = 0x00000020;
    const ADD_REACTIONS = 0x00000040;
    const VIEW_AUDIT_LOG = 0x00000080;
    const READ_MESSAGES = 0x00000400;
    const SEND_MESSAGES = 0x00000800;
    const SEND_TTS_MESSAGES = 0x00001000;
    const MANAGE_MESSAGES = 0x00002000;
    const EMBED_LINKS = 0x00004000;
    const ATTACH_FILES = 0x00008000;
    const READ_MESSAGE_HISTORY = 0x00010000;
    const MENTION_EVERYONE = 0x00020000;
    const USE_EXTERNAL_EMOJIS = 0x00040000;
    const CONNECT = 0x00100000;
    const SPEAK = 0x00200000;
    const MUTE_MEMBERS = 0x00400000;
    const DEAFEN_MEMBERS = 0x00800000;
    const MOVE_MEMBERS = 0x01000000;
    const USE_VAD = 0x02000000;
    const CHANGE_NICKNAME = 0x04000000;
    const MANAGE_NICKNAMES = 0x08000000;
    const MANAGE_ROLES = 0x10000000;
    const MANAGE_WEBHOOKS = 0x20000000;
    const MANAGE_EMOJIS = 0x40000000;

    public static function calculatePermissions($perms = []) {
        $perm = 0x0;
        foreach ($perms as $p) {
            $perm += $p;
        }

        return $perm;
    }

}