<?php

namespace LurdesBot\Lurdes\Commands;

use LurdesBot\Discord\DiscordCommand;

class HelpCommand extends DiscordCommand {

    public function execute($params) {
        $this->message->channel->sendMessage("```Markdown\n# ❓❓ Comandos Lurdes Bot ❓❓ #```\n")->then(function () {
            $at = CONFIG['discord_command_identifier'];
            $lines = '';
            $commands = require(base_path('bot/Config/commands.php'));

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

                $this->message->channel->sendMessage($lines);
                $lines = '';
            }

        });
    }

}