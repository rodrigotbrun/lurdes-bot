<?php

namespace LurdesBot\Discord;

use Discord\Discord;
use Hook\Hook;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class DiscordBotLoop extends Discord {

    private $commands = [];

    /**
     * DiscordBotLoop constructor.
     */
    public function __construct() {
//        $logger = new Logger('discord_loop');
//        $file_handler = new StreamHandler(storage_path('logs/discord-loop.log'));
//        $logger->pushHandler($file_handler);

        parent::__construct([
            'token' => CONFIG['discord_bot_token'],
//            'logger' => $logger,
//            'loggerLevel' => 'DEBUG'
        ]);

        $this->commands = require base_path('bot/Config/commands.php');
    }

    public function loop() {
//        Hook::getInstance()->fire('on-discord-ready', [
//            'teste' => ' Mundo'
//        ]);

        $this->on('ready', function ($discord) {
            $discord->on('message', function ($message, $discord) {
                if (!$message->author->user->bot) {
                    if (starts_with($message->content, CONFIG['discord_command_identifier'])) {
                        $m = explode(' ', $message->content);
                        $cmd = $m[0];
                        $cmd = str_replace(CONFIG['discord_command_identifier'], '', $cmd);
                        unset($m[0]);
                        $message->content = implode(' ', $m);

                        if (preg_match('/[a-z\_\-]{1}[a-z0-9\_\-\+]/i', $cmd)) {
                            $cmd = strtolower($cmd);
                            $params = explode(' ', $message->content);

                            if (isset($this->commands[$cmd])) {
                                $class = $this->commands[$cmd]['class'];
                                echo '+ Command "', $cmd, '" received from "', $message->author->username, '#', $message->author->id, '" --> ', $class, PHP_EOL;

                                if (class_exists($class, true)) {
                                    $commandExecution = new $class($message, $discord);
                                    $commandExecution->execute($params);
                                } else {
                                    $message->reply('🤕 Não conheço este comando!');

                                }
                            } else {
                                if ($cmd === 'help') {
                                    $this->sendHelp($message);
                                } else {
                                    $message->reply('🤒 Não conheço este comando!');
                                }
                            }
                        }
                    }
                }
            });

        });

        $this->run();
    }

    public function sendHelp($message) {
        $at = CONFIG['discord_command_identifier'];
        $lines = '';
        $commands = $this->commands;

        $grouped = [];
        $ungrouped = [];
        $i = 0;
        foreach ($commands as $name => $c) {
            if (isset($c['help']['group'])) {
                if (!isset($grouped[$c['help']['group']]))
                    $grouped[$c['help']['group']] = [];

                $grouped[$c['help']['group']][$name] = $c;
            } else {
                $ungrouped[$name] = $c;
            }

            $i++;
        }

        if (count($ungrouped) > 0) {
            foreach ($ungrouped as $name => $c) {
                $params = '';
                if (isset($c['help']['params'])) {
                    $params = array_keys($c['help']['params']);
                    $params = ' `{' . implode('}` `{', $params) . '}` ';
                }

                $lines .= "- `{$at}{$name}`{$params}   →   {$c['help']['description']}\n";
            }
        }

        foreach ($grouped as $groupname => $commands) {
            $lines .= "\n```css\n{$groupname}```\n";

            foreach ($commands as $name => $c) {
                $params = '';
                if (isset($c['help']['params'])) {
                    $params = array_keys($c['help']['params']);
                    $params = ' `{' . implode('}` `{', $params) . '}` ';
                }

                $lines .= "- `{$at}{$name}`{$params}   →   {$c['help']['description']}\n";
            }
        }

        $help = "```Markdown\n# ❓❓ Comandos Lurdes Bot ❓❓ #```\n{$lines}";
        $message->channel->sendMessage($help);
    }

}