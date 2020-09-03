<?php


namespace MuteSystem\Events;


use MuteSystem\MuteSystem;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\utils\Config;

class EventListener implements Listener {

    public function onChat(PlayerChatEvent $event) {
        $cfg = new Config("plugin_data/MuteSystem/mutes.yml");
        if ($cfg->get($event->getPlayer()->getName())) {
            $unmute = $cfg->getNested($event->getPlayer()->getName() . ".Bis");
            $now = new \DateTime("now");
                if ($now < new \DateTime($unmute)) {
                    $event->getPlayer()->sendMessage(MuteSystem::getPrefix() . "§cDu bist gemutet!");
                    $event->getPlayer()->sendMessage(MuteSystem::getPrefix() . "§cGrund §8► §e" . $cfg->getNested($event->getPlayer()->getName() . ".Grund"));
                    $event->getPlayer()->sendMessage(MuteSystem::getPrefix() . "§cEntmute §8► §e" . $cfg->getNested($event->getPlayer()->getName() . ".Bis"));
                    $event->getPlayer()->sendMessage(MuteSystem::getPrefix() . "§cMuter §8► §e" . $cfg->getNested($event->getPlayer()->getName() . ".Muter"));
                    $event->setCancelled(true);
                } else {
                    $event->setCancelled(false);
                }
            }
    }
}