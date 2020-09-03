<?php


namespace MuteSystem\API;


use MuteSystem\MuteSystem;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;

class API {

    public static function mutePlayer(Player $player, Player $muter, $time, string $reason = ""){
        $cfg = new Config("plugin_data/MuteSystem/mutes.yml");
        $p = $player;
        $cfg->setNested($p->getName() . ".Grund", $reason);
        $cfg->setNested($p->getName() . ".Bis", date("Y-m-d H:i:s"));
        $cfg->setNested($p->getName() . ".Muter", $muter);
        $cfg->save();
        $date = new \DateTime("+" . $time . " Hour");
        $date->setTimezone(new \DateTimeZone("Europe/Berlin"));
        $cfg->setNested($p->getName() . ".Bis", $date->format("Y-m-d H:i:s"));
        $cfg->save();
        $cfg->reload();
        $player->sendMessage(MuteSystem::getPrefix() . "§7Du wurdest von §e" . $muter->getName() . " §c§lgemutet§r§7!");
        $muter->sendMessage(MuteSystem::getPrefix() . "§e" . $player->getName() . " §7wurde erfolgreich §a§lgemutet§r§7!");
        foreach (MuteSystem::getInstance()->getServer()->getOnlinePlayers() as $op) {
            if ($op->hasPermission("mutes.see")) {
                $op->sendMessage(MuteSystem::getPrefix() . "§aNeuer §c§lMute§r§a!");
                $op->sendMessage("");
                $op->sendMessage(MuteSystem::getPrefix() . "§aSpieler §8► §c§l" . $player->getName());
                $op->sendMessage(MuteSystem::getPrefix() . "§aMuter §8► §c§l" . $muter->getName());
                $op->sendMessage(MuteSystem::getPrefix() . "§aGrund §8► §c§l" . $reason);
                $explode = explode(", ", $cfg->get($player->getName()));
                $op->sendMessage(MuteSystem::getPrefix() . "§aBis §8► §c§l" . $cfg->getNested($player->getName() . ".Bis"));
            } else {
                return true;
            }
        }
    }

    public static function unmutePlayer($player, CommandSender $unmuter) {
        $cfg = new Config("plugin_data/MuteSystem/mutes.yml");
        $cfg->remove($player);
        $cfg->save();
        $p = Server::getInstance()->getPlayer($player);
        if (!$p) {
            return true;
        } else {
            $p->sendMessage(MuteSystem::getPrefix() . "§7Du wurdest von §e" . $unmuter->getName() . " §a§lentmutet§r§7!");
        }
        foreach (MuteSystem::getInstance()->getServer()->getOnlinePlayers() as $op) {
            if ($op->hasPermission("mutes.see")) {
                $op->sendMessage(MuteSystem::getPrefix() . "§aNeuer §c§lUnmute§r§a!");
                $op->sendMessage("");
                $op->sendMessage(MuteSystem::getPrefix() . "§aSpieler §8► §c§l" . $player);
                $op->sendMessage(MuteSystem::getPrefix() . "§aUnmuter §8► §c§l" . $unmuter->getName());
            } else {
                return true;
            }
        }
    }
}