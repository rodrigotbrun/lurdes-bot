<?php

namespace LurdesBot\Discord;

use Discord\Discord;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;

abstract class DiscordCommand {

    /** @var Message */
    protected $message;

    /** @var Discord */
    protected $discord;

    /** @var array */
    protected $parameters;

    /**
     * DiscordCommand constructor.
     * @param Message $message
     * @param Discord $discord
     */
    public function __construct($message, $discord) {
        $this->message = $message;
        $this->discord = $discord;
    }

    /**
     * @param array $params
     * @return mixed
     */
    abstract public function execute($params);

    /** @return Channel|null */
    protected function userCurrentVoiceChannel() {
        $voiceChannel = null;
        foreach ($this->discord->guilds as $guild) {
            $voice_channels = $guild->channels->getAll('type', Channel::TYPE_VOICE);
            foreach ($voice_channels as $v) {
                $members = $v->members;
                foreach ($members as $member) {
                    if ($member->user_id === $this->message->author->id) {
                        $voiceChannel = $v;
                        break;
                    }
                }
            }
        }

        return $voiceChannel;
    }

}