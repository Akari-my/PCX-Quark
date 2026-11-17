<?php

namespace Mellooh\PureChatX\listener;

use Mellooh\PureChatX\PCX;
use Mellooh\PurePermsX\PPX;
use quark\event\Listener;
use quark\event\player\PlayerChatEvent;
use quark\event\player\PlayerJoinEvent;
use quark\lang\Translatable;
use quark\player\chat\ChatFormatter;

class ChatListener implements Listener{

    private PCX $plugin;

    public function __construct(PCX $plugin){
        $this->plugin = $plugin;
    }

    public function onJoin(PlayerJoinEvent $event): void{
        $player = $event->getPlayer();
        $name = strtolower($player->getName());
        $ppx = PPX::getInstance();
        if($ppx === null) return;

        $group = $ppx->getUserManager()->getGroup($name) ?? "guest";
        $formatManager = $this->plugin->getFormatManager();
        $tagGroup = $formatManager->getGroupByLink($group) ?? "guest";
        $prefix = $formatManager->getPrefix($tagGroup);

        $player->setNameTag($prefix . $player->getDisplayName());
    }

    public function onChat(PlayerChatEvent $event): void {
        $player = $event->getPlayer();
        $name = strtolower($player->getName());

        $ppx = PPX::getInstance();
        if($ppx === null) return;

        $group = $ppx->getUserManager()->getGroup($name) ?? "guest";
        $fm = $this->plugin->getFormatManager();
        $tagGroup = $fm->getGroupByLink($group) ?? "guest";

        $prefix = $fm->getPrefix($tagGroup);
        $suffix = $fm->getSuffix($tagGroup);
        $format = $fm->getFormat($tagGroup);
        $nameTagFormat = $fm->getNameTagFormat($tagGroup);

        $message = $event->getMessage();

        $formattedChat = str_replace(
            ["{prefix}", "{name}", "{suffix}", "{group}", "{message}"],
            [$prefix, $player->getDisplayName(), $suffix, $group, $message],
            $format
        );

        $event->setFormatter(new class($formattedChat) implements ChatFormatter{
            public function __construct(private string $formatted){}

            public function format(string $username, string $message) : Translatable|string{
                return $this->formatted;
            }
        });

        $formattedNameTag = str_replace(
            ["{prefix}", "{name}", "{suffix}", "{group}"],
            [$prefix, $player->getDisplayName(), $suffix, $group],
            $nameTagFormat
        );

        $player->setNameTag($formattedNameTag);
    }
}