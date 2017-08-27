<?php

namespace LurdesBot\Discord;

use Discord\Discord;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

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

        $this->logger = new Logger('cmd_logger');
        $file_handler = new StreamHandler(base_path('storage/logs/commands.log'));
        $this->logger->pushHandler($file_handler);
    }

    /**
     * @param array $params
     * @return mixed
     */
    abstract public function execute($params);

    public function fire($params, $classname) {
        $this->logger->notice('------------------------ ' . $classname . '------------------------');
        try {
            $this->execute($params);
        } catch (\Exception $e) {
            $this->logger->error($e);
            $this->message->reply('🤢 ' . $e->getMessage());
        }
    }

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