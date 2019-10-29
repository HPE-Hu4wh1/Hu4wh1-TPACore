<?php
/*  _____  ____    _    
*  |_   _||  _ \  / \   
*    | |  | |_) |/ _ \  
*    | |  |  __// ___ \ 
*    |_|  |_|  /_/   \_\
 */
namespace Hu4wh1\Commands;

use Hu4wh1\BaseAPI;

use pocketmine\command\Command;

use pocketmine\command\CommandSender;

use pocketmine\Player;

use pocketmine\utils\TextFormat;

class Tpa extends Command{

/** @var BaseAPI */

private $plugin;

public function __construct(){

$this->plugin = BaseAPI::getInstance();

parent::__construct("tpa", "Tpa command!");

$this->setPermission("essentials.tpa.commands");

}

public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{

if(!$this->testPermission($sender)) return false;

if(empty($args[0])){

$sender->sendMessage(TextFormat::RED."No players found!");

}else{

$player = $this->plugin->getServer()->getPlayer($args[0]);

if($player instanceof Player){

$this->plugin->setInvite($sender,$player);

$player->sendMessage(TextFormat::AQUA . $sender->getName() . TextFormat::GREEN . " has sent you a teleport request!\n".TextFormat::GOLD."To Accept".TextFormat::GREEN." /tpak\n".TextFormat::GOLD."To Reject".TextFormat::RED." /tpar");

$sender->sendMessage(TextFormat::AQUA . $player->getName() . TextFormat::GREEN . " Player Has Recieved Request!");

}else{

$sender->sendMessage(TextFormat::RED . "Please enter a valid player.");

 }

}

return true;

 }

}
