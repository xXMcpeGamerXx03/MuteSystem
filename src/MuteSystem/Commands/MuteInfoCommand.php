<?php


namespace MuteSystem\Commands;


use MuteSystem\MuteSystem;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use pocketmine\utils\Config;

class MuteInfoCommand extends Command {

    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("muteinfo.command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
        if ($sender->hasPermission($this->getPermission())) {
            if (isset($args[0])) {
                if (file_exists("players/" . $args[0] . ".dat")) {
                    $cfg = new Config("plugin_data/MuteSystem/mutes.yml");
                    $sender->sendMessage(MuteSystem::getPrefix() . "§7MuteInfo über §e" . $args[0]);
                    $sender->sendMessage("");
                    $sender->sendMessage(MuteSystem::getPrefix() . "§7Name §8► §e" . $args[0]);
                    $sender->sendMessage(MuteSystem::getPrefix() . "§aWar schon auf dem Server drauf!");
                    if ($cfg->get($args[0])) {
                        if (Server::getInstance()->getPlayer($args[0])) {
                            $sender->sendMessage(MuteSystem::getPrefix() . "§7Satus §8► §aOnline§8(§eGemutet§8)");
                        } else {
                            $sender->sendMessage(MuteSystem::getPrefix() . "§7Satus §8► §cOffline§8(§eGemutet§8)");
                        }
                    } else {
                        if (Server::getInstance()->getPlayer($args[0])) {
                            $sender->sendMessage(MuteSystem::getPrefix() . "§7Satus §8► §aOnline§8(§eNicht Gemutet§8)");
                        } else {
                            $sender->sendMessage(MuteSystem::getPrefix() . "§7Satus §8► §cOffline§8(§eNicht Gemutet§8)");
                        }
                    }
                    if (($p = Server::getInstance()->getPlayer($args[0]))) {
                        $sender->sendMessage(MuteSystem::getPrefix() . "§7IP §8► §e" . $p->getAddress());
                    } else {
                        $sender->sendMessage(MuteSystem::getPrefix() . "§7IP §8► §c/");
                    }
                    if (($p = Server::getInstance()->getPlayer($args[0]))) {
                        $sender->sendMessage(MuteSystem::getPrefix() . "§7UUID §8► §e" . $p->getUniqueId());
                    } else {
                        $sender->sendMessage(MuteSystem::getPrefix() . "§7UUID §8► §c/");
                    }
                } else {
                    $cfg = new Config("plugin_data/MuteSystem/mutes.yml");
                    $sender->sendMessage(MuteSystem::getPrefix() . "§7MuteInfo über §e" . $args[0]);
                    $sender->sendMessage("");
                    $sender->sendMessage(MuteSystem::getPrefix() . "§7Name §8► §e" . $args[0]);
                    $sender->sendMessage(MuteSystem::getPrefix() . "§cWar noch nie auf dem Server drauf!");
                    if ($cfg->get($args[0])) {
                        if (Server::getInstance()->getPlayer($args[0])) {
                            $sender->sendMessage(MuteSystem::getPrefix() . "§7Satus §8► §aOnline§8(§eGemutet§8)");
                        } else {
                            $sender->sendMessage(MuteSystem::getPrefix() . "§7Satus §8► §cOffline§8(§eGemutet§8)");
                        }
                    } else {
                        if (Server::getInstance()->getPlayer($args[0])) {
                            $sender->sendMessage(MuteSystem::getPrefix() . "§7Satus §8► §aOnline§8(§eNicht Gemutet§8)");
                        } else {
                            $sender->sendMessage(MuteSystem::getPrefix() . "§7Satus §8► §cOffline§8(§eNicht Gemutet§8)");
                        }
                    }
                    if (($p = Server::getInstance()->getPlayer($args[0]))) {
                        $sender->sendMessage(MuteSystem::getPrefix() . "§7IP §8► §e" . $p->getAddress());
                    } else {
                        $sender->sendMessage(MuteSystem::getPrefix() . "§7IP §8► §c/");
                    }
                    if (($p = Server::getInstance()->getPlayer($args[0]))) {
                        $sender->sendMessage(MuteSystem::getPrefix() . "§7UUID §8► §e" . $p->getUniqueId());
                    } else {
                        $sender->sendMessage(MuteSystem::getPrefix() . "§7UUID §8► §c/");
                    }
                }
            } else {
                $sender->sendMessage(MuteSystem::getPrefix() . "§c/muteinfo <player>");
            }
        } else {
            $sender->sendMessage(MuteSystem::getPrefix() . "§cDafür hast du keine Rechte!");
        }
        return true;
    }
}