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

    /** @var integer */
    protected $mode;

    /** @var \Closure[] */
    public static $onChooseOption = [];

    /** @var array[] */
    public static $optionsData = [];

    /** @var string[] */
    public static $lockedTo = [];

    /** @var Logger */
    public static $logger;

    /**
     * DiscordCommand constructor.
     * @param Message $message
     * @param Discord $discord
     */
    public function __construct($message, $discord) {
        $this->message = $message;
        $this->discord = $discord;

        self::$logger = new Logger('cmd_logger');
        $file_handler = new StreamHandler(base_path('storage/logs/commands.log'));
        self::$logger->pushHandler($file_handler);
    }

    /**
     * @param array $params
     * @return mixed
     */
    abstract public function execute($params);

    public function fire($params, $classname) {
        self::$logger->notice('------------------------ ' . $classname . '------------------------');
        try {
            $this->execute($params);
        } catch (\Exception $e) {
            self::$logger->error($e);
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

    /**
     * @param $userRequested string
     * @param $className string
     * @param $data array
     * @param $callback \Closure
     */
    protected function waitOptionChoose($userRequested, $className, $data, $callback) {
        echo '+++ Waiting user ' . $this->message->author->username . '#' . $this->message->author->id . ' to send an answer --> ' . $className, PHP_EOL;
        DiscordCommand::$lockedTo[$userRequested] = $className;
        DiscordCommand::$optionsData[$userRequested] = $data;
        DiscordCommand::$onChooseOption[$userRequested] = $callback;
    }

    public static function onChooseOption($userRequested, $position, Discord $discord, Message $message) {
        if (!preg_match('/[0-9]+/', $position)) {
            $message->reply('Opção inválida! Favor responder usando o número da linha do resultado desejado! ( ou envie `-` para cancelar a solicitação)');
            return;
        }

        $closure = DiscordCommand::$onChooseOption[$userRequested];
        $data = DiscordCommand::$optionsData[$userRequested];

        echo '+++++ User ' . $message->author->username . '#' . $message->author->id . ' answered with option ' . $position . ' --> ' . DiscordCommand::$lockedTo[$userRequested], PHP_EOL;

        try {
            $closure($data, $position - 1, $discord, $message);
        } catch (\Exception $e) {
            self::$logger->error($e);
            $message->reply('🤢 ' . $e->getMessage());
        }

        unset(DiscordCommand::$onChooseOption[$userRequested]);
        unset(DiscordCommand::$lockedTo[$userRequested]);
        unset(DiscordCommand::$optionsData[$userRequested]);
    }

}