<?php

namespace Hu4wh1;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use Hu4wh1\Managers\CommandManager;
    
class BaseAPI extends PluginBase{

    /** @var BaseAPI */
    private static $api;
    /** @var Config */
    public $warn;
    /** @var TpaCommands */
    public $invite = [];
    
    public function onLoad(){
        self::$api = $this;
    }

    public function onEnable(){
        @mkdir($this->getDataFolder());
        @mkdir($this->getDataFolder() . "Players/");

        CommandManager::init();

        $this->getLogger()->info(TextFormat::GOLD . $this->getName() . TextFormat::GREEN . " activated!");
    }

    public static function getInstance() : BaseAPI{
        return self::$api;
    }

    public function getFileControl(string $name) : void{
        $dir = $this->getDataFolder() . $name . ".yml";
        if(!file_exists($dir)) $this->warn = new Config($dir, Config::YAML);
    }

    public function setWarn(string $name, string $reason, int $point) : void{
        $this->getFileControl($name);

        $data = new Config($this->getDataFolder() . $name . ".yml", Config::YAML);
        $data->set($reason, $point);
        $data->save();

        $this->getPointControl($name);
    }

    public function getPointControl(string $name) : void{
        $data = new Config($this->getDataFolder() . $name . ".yml", Config::YAML);
        $points = array_sum($data->getAll());

        $player = $this->getServer()->getPlayer($name);
        if($points >= 10){
            $player->kick(TextFormat::RED . "You have been removed from the server since you reached 10 points.");
            $player->setBanned(true);
        }
    }
    
    public function setInvite(Player $sender, Player $player) : void{
        $this->invite[$player->getName()] = $sender->getName();
    }
    
    public function getInviteControl(string $name) : bool{
        return isset($this->invite[$name]);
    }
    
    public function getInvite($name) : string{
        return $this->invite[$name];
    }
    
    public function tpak(string $name) : void{
        $player = $this->getServer()->getPlayer($name);
        if($this->getInviteControl($name)){
            $sender = $this->getServer()->getPlayer($this->getInvite($name));
            $sender->teleport($player->asPosition());
            unset($this->invite[$name]);
            $sender->sendMessage(TextFormat::AQUA . $name . " Player has accepted your request.");
        }else{
            $player->sendMessage(TextFormat::RED . "you did not receive an invitation.");
        }
    }
     
    public function tpar($name) : void{
           $player = $this->getServer()->getPlayer($name);
        if($this->getInviteControl($name)){
            $sender = $this->getServer()->getPlayer($this->getInvite($name));
            unset($this->invite[$name]);
            $sender->sendMessage(TextFormat::AQUA . $name . TextFormat::RED . "Rejected your teleport request");

        }else{
            $player->sendMessage(TextFormat::RED . "You haven't receive an invitation.");
        }
    }
    
}

