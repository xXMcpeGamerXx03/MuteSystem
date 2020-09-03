<?php


namespace MuteSystem;


use MuteSystem\Commands\MuteCommand;
use MuteSystem\Commands\MuteInfoCommand;
use MuteSystem\Commands\Mutelistommand;
use MuteSystem\Commands\UnmuteCommand;
use MuteSystem\Events\EventListener;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class MuteSystem extends PluginBase implements Listener {

    public static $prefix;

    public static $instance;

    public function onEnable(): void{
        self::$instance = $this;
        $this->saveResource("config.yml");
        $cfg = new Config($this->getDataFolder(). "config.yml", 2);
        self::$prefix = $cfg->get("Prefix");
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        $this->getServer()->getCommandMap()->register("mute", new MuteCommand("mute", "Mute Command"));
        $this->getServer()->getCommandMap()->register("muteinfo", new MuteInfoCommand("muteinfo", "Muteinfo Command"));
        $this->getServer()->getCommandMap()->register("unmute", new UnmuteCommand("unmute", "Unmute Command"));
        $this->getServer()->getCommandMap()->register("mutelist", new Mutelistommand("mutelist", "Mutelist Command"));
    }

    public static function getPrefix() {
        return self::$prefix;
    }

    public static function getInstance(): self {
        return self::$instance;
    }
}