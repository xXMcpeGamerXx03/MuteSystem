<?php


namespace MuteSystem\Commands;


use MuteSystem\API\API;
use MuteSystem\MuteSystem;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;

class MuteCommand extends Command {

    public function __construct(string $name, string $description = "", array $aliases = [])
    {
        parent::__construct($name, $description, "§c/mute <player> <reason> <hours>", $aliases);
        $this->setPermission("mute.command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
        if ($sender->hasPermission($this->getPermission())){
            if (isset($args[0])) {
                if (isset($args[1])) {
                    if (isset($args[2])) {
                        $cfg = new Config("plugin_data/MuteSystem/mutes.yml");
                        if (($p = Server::getInstance()->getPlayer($args[0]))) {
                                if ($p === $sender) {
                                    $sender->sendMessage(MuteSystem::getPrefix() . "§cDu kannst dich nicht selber Muten!");
                                    return true;
                                } else {
                                    if ($cfg->get($args[0])) {
                                        $sender->sendMessage(MuteSystem::getPrefix() . "§cSpieler ist bereits gemutet!");
                                        return true;
                                    } else {
                                        if (!$sender instanceof Player) {
                                            $cfg->setNested($p->getName() . ".Grund", $args[1]);
                                            $cfg->setNested($p->getName() . ".Bis", date("Y-m-d H:i:s"));
                                            $cfg->setNested($p->getName() . ".Muter", $sender->getName());
                                            $cfg->save();
                                            $date = new \DateTime("+" . $args[2] . " Hour");
                                            $date->setTimezone(new \DateTimeZone("Europe/Berlin"));
                                            $cfg->setNested($p->getName() . ".Bis", $date->format("Y-m-d H:i:s"));
                                            $cfg->save();
                                            $cfg->reload();
                                            $p->sendMessage(MuteSystem::getPrefix() . "§7Du wurdest von §e" . $sender->getName() . " §c§lgemutet§r§7!");
                                            $sender->sendMessage(MuteSystem::getPrefix() . "§e" . $p->getName() . " §7wurde erfolgreich §a§lgemutet§r§7!");
                                            foreach (MuteSystem::getInstance()->getServer()->getOnlinePlayers() as $op) {
                                                if ($op->hasPermission("mutes.see")) {
                                                    $op->sendMessage(MuteSystem::getPrefix() . "§aNeuer §c§lMute§r§a!");
                                                    $op->sendMessage("");
                                                    $op->sendMessage(MuteSystem::getPrefix() . "§aSpieler §8► §c§l" . $p->getName());
                                                    $op->sendMessage(MuteSystem::getPrefix() . "§aMuter §8► §c§l" . $sender->getName());
                                                    $op->sendMessage(MuteSystem::getPrefix() . "§aGrund §8► §c§l" . $args[1]);
                                                    $op->sendMessage(MuteSystem::getPrefix() . "§aBis §8► §c§l" . $cfg->getNested($p->getName() . ".Bis"));
                                                } else {
                                                    return true;
                                                }
                                            }
                                        } else {
                                            $cfg = new Config("plugin_data/MuteSystem/mutes.yml");
                                            $cfg->setNested($p->getName() . ".Grund", $args[1]);
                                            $cfg->setNested($p->getName() . ".Bis", date("Y-m-d H:i:s"));
                                            $cfg->setNested($p->getName() . ".Muter", $sender->getName());
                                            $cfg->save();
                                            $date = new \DateTime("+" . $args[2] . " Hour");
                                            $date->setTimezone(new \DateTimeZone("Europe/Berlin"));
                                            $cfg->setNested($p->getName() . ".Bis", $date->format("Y-m-d H:i:s"));
                                            $cfg->save();
                                            $cfg->reload();
                                            $p->sendMessage(MuteSystem::getPrefix() . "§7Du wurdest von §e" . $sender->getName() . " §c§lgemutet§r§7!");
                                            $sender->sendMessage(MuteSystem::getPrefix() . "§e" . $p->getName() . " §7wurde erfolgreich §a§lgemutet§r§7!");
                                            foreach (MuteSystem::getInstance()->getServer()->getOnlinePlayers() as $op) {
                                                if ($op->hasPermission("mutes.see")) {
                                                    $op->sendMessage(MuteSystem::getPrefix() . "§aNeuer §c§lMute§r§a!");
                                                    $op->sendMessage("");
                                                    $op->sendMessage(MuteSystem::getPrefix() . "§aSpieler §8► §c§l" . $p->getName());
                                                    $op->sendMessage(MuteSystem::getPrefix() . "§aMuter §8► §c§l" . $sender->getName());
                                                    $op->sendMessage(MuteSystem::getPrefix() . "§aGrund §8► §c§l" . $args[1]);
                                                    $op->sendMessage(MuteSystem::getPrefix() . "§aBis §8► §c§l" . $cfg->getNested($p->getName() . ".Bis"));
                                                } else {
                                                    return true;
                                                }
                                            }
                                        }
                                    }
                                }
                            } else{
                                $sender->sendMessage(MuteSystem::getPrefix() . "§7Spieler ist Offline.");
                            }
                    } else {
                        $sender->sendMessage(MuteSystem::getPrefix() . $this->getUsage());
                    }
                } else {
                    $sender->sendMessage(MuteSystem::getPrefix() . $this->getUsage());
                }
            } else {
                $sender->sendMessage(MuteSystem::getPrefix() . $this->getUsage());
            }
        } else {
            $sender->sendMessage(MuteSystem::getPrefix() . "§cDafür hast du keine Rechte!");
        }
        return true;
    }
}
