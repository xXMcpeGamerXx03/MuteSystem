<?php


namespace MuteSystem\Commands;


use MuteSystem\API\API;
use MuteSystem\MuteSystem;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use pocketmine\utils\Config;

class UnmuteCommand extends Command {

    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("unmute.command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
        if ($sender->hasPermission($this->getPermission())){
            if (isset($args[0])) {
                $cfg = new Config("plugin_data/MuteSystem/mutes.yml");
                if ($cfg->get($args[0])) {
                    API::unmutePlayer($args[0], $sender);
                    $sender->sendMessage(MuteSystem::getPrefix() . "§e" . $args[0] . " §7wurde erfolgreich §a§lentmutet§r§7!");
                } else {
                    $sender->sendMessage(MuteSystem::getPrefix() . "§cDieser Spieler ist nicht gemutet!");
                }
            } else {
                $sender->sendMessage(MuteSystem::getPrefix() . "§c/unmute <player>");
            }
        } else {
            $sender->sendMessage(MuteSystem::getPrefix() . "§cDafür hast du keine Rechte!");
        }
        return true;
    }
}