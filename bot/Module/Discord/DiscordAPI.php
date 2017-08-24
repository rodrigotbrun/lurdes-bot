<?php

namespace LurdesBot\Discord;

use Discord\Voice\VoiceClient;
use RestCord\DiscordClient;

class DiscordAPI extends DiscordClient {

    /** @var DiscordAPI */
    private static $instance = null;

    /** @var VoiceClient */
    private static $voiceClient;

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

    /**
     * @return VoiceClient
     */
    public static function getVoiceClient() {
        return self::$voiceClient;
    }

    /**
     * @param VoiceClient $voiceClient
     */
    public static function setVoiceClient($voiceClient) {
        self::$voiceClient = $voiceClient;
    }

}