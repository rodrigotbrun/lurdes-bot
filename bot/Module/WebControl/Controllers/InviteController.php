<?php

namespace LurdesBot\WebControl\Controllers;

use LurdesBot\Discord\Entity\DiscordPermission;
use Slim\Http\Request;
use Slim\Http\Response;

class InviteController extends Controller {

    /**
     * @param Request $request
     * @param Response $response
     * @param array $arguments
     *
     * @return mixed
     */
    function run(Request $request, Response $response, array $arguments = []) {
        $permission = DiscordPermission::calculatePermissions([
            DiscordPermission::CREATE_INSTANT_INVITE,
            DiscordPermission::ADD_REACTIONS,
            DiscordPermission::VIEW_AUDIT_LOG,
            DiscordPermission::READ_MESSAGES,
            DiscordPermission::READ_MESSAGE_HISTORY,
            DiscordPermission::SEND_MESSAGES,
            DiscordPermission::SEND_TTS_MESSAGES,
            DiscordPermission::MANAGE_MESSAGES,
            DiscordPermission::EMBED_LINKS,
            DiscordPermission::ATTACH_FILES,
            DiscordPermission::MENTION_EVERYONE,
            DiscordPermission::USE_EXTERNAL_EMOJIS,
            DiscordPermission::CONNECT,
            DiscordPermission::SPEAK,
            DiscordPermission::MUTE_MEMBERS,
            DiscordPermission::USE_VAD,
            DiscordPermission::CHANGE_NICKNAME,
            DiscordPermission::MANAGE_NICKNAMES,
        ]);

        $discordInviteURL = 'https://discordapp.com/api/oauth2/authorize?client_id=' .
            CONFIG['discord_bot_id'] .
            '&scope=bot&permissions=' . $permission;

        echo "<a href='{$discordInviteURL}'>$discordInviteURL</a>";
    }

}
