<?php

namespace Hu4wh1\Managers;

use Hu4wh1\Commands\{Tpa, TpaAll, Tpak, Tpar};
use pocketmine\utils\TextFormat;
use Hu4wh1\BaseAPI;

class CommandManager{

    public static function init() : void{
        foreach(self::getCommands() as $key => $value){
            BaseAPI::getInstance()->getServer()->getCommandMap()->register($key, $value);
        }
        BaseAPI::getInstance()->getLogger()->notice(TextFormat::DARK_GRAY . self::getCommandCount() . TextFormat::LIGHT_PURPLE . " commands have been loaded.");
    }

    public static function getCommands() : array{
        return [
            "tpa" => new Tpa(),
            "tpak" => new Tpak(),
            "tpar" => new Tpar(),
            "tpaall" => new TpaAll(),

        ];
    }

    public static function getCommandCount() : int{
        return count(self::getCommands());
    }
}

