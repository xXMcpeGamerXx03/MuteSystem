<?php


namespace MuteSystem\Commands;


use MuteSystem\MuteSystem;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\utils\Config;

class Mutelistommand extends Command
{
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("mutelist.command");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
        if ($sender->hasPermission($this->getPermission())) {
            $cfg = new Config("plugin_data/MuteSystem/mutes.yml");

            if (empty($cfg->getAll(true))) {
                $sender->sendMessage(MuteSystem::getPrefix() . "§cKeine Mutes verfügbar!");
                return true;
            } else {
                $list = array();
                foreach ($cfg->getAll(true) as $players) {
                    array_push($list, $players);
                }
                $sender->sendMessage(MuteSystem::getPrefix() . "§cMutes: §e" . implode(", ", $list));
            }
        } else {
            $sender->sendMessage(MuteSystem::getPrefix() . "§cDafür hast du keine Rechte!");
        }
        return true;
    }
}