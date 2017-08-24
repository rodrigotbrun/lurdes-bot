<?php

namespace LurdesBot\Discord;

use Discord\Discord;
use Discord\Parts\Channel\Message;

abstract class DiscordCommand {

    /** @var Message */
    protected $message;

    /** @var Discord */
    protected $discord;

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

}