<?php

namespace LurdesBot\Discord;

use RestCord\DiscordClient;

class DiscordAPI extends DiscordClient {

    /** @var DiscordAPI */
    private static $instance = null;

    /**
     * DiscordAPI constructor.
     */
    public function __construct() {
        parent::__construct(['token' => CONFIG['discord_bot_token']]);
    }

    /**
     * @return DiscordAPI
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new DiscordAPI();
        }

        return self::$instance;
    }

}