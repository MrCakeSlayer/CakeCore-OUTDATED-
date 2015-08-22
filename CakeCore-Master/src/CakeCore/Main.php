<?php
/*
   _____           _                _____                       
  / ____|         | |              / ____|                      
 | |        __ _  | | __   ___    | |        ___    _ __    ___ 
 | |       / _` | | |/ /  / _ \   | |       / _ \  | '__|  / _ \
 | |____  | (_| | |   <  |  __/   | |____  | (_) | | |    |  __/
  \_____|  \__,_| |_|\_\  \___|    \_____|  \___/  |_|     \___|

*/
namespace CakeCore;
//General
use pocketmine\scheduler\PluginTask;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use pocketmine\level\Level;
//Events
use pocketmine\event\Event;
use pocketmine\event\EventPriority;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerKickEvent;
//Future Use, Death Kick
use pocketmine\event\player\PlayerDeathEvent;
//Future Use, SocialSpy
use pocketmine\event\player\PlayerCommandPreprocessEvent;

class Main extends PluginBase implements Listener{
    /*
    Console Message When Successfully Enabled
    */
    public function onEnable(){
	$this->saveDefaultConfig();
    $this->getServer()->getPluginManager()->registerEvents($this,$this);
    $this->getServer()->getLogger()->info(TextFormat::GREEN."[CakeCore] Plugin successfully Enabled!");
    @mkdir($this->getDataFolder());
    $this->cfg = $this->getConfig()->getAll();
    $time = intval($this->cfg["time"]) * 20;
    $this->task = $this->getServer()->getScheduler()->scheduleRepeatingTask(new Tasks\Task($this), $time);
    $this->ptask = $this->getServer()->getScheduler()->scheduleRepeatingTask(new Tasks\PopupTask($this), $time);
    }
    /*
    Translate Colours For Messages :D
    */
    public $cfg;
    
    public $task;
    
    public function translateColors($symbol, $message){
        //Numbers
		$message = str_replace($symbol."0", TextFormat::BLACK, $message);
		$message = str_replace($symbol."1", TextFormat::DARK_BLUE, $message);
		$message = str_replace($symbol."2", TextFormat::DARK_GREEN, $message);
		$message = str_replace($symbol."3", TextFormat::DARK_AQUA, $message);
		$message = str_replace($symbol."4", TextFormat::DARK_RED, $message);
		$message = str_replace($symbol."5", TextFormat::DARK_PURPLE, $message);
		$message = str_replace($symbol."6", TextFormat::GOLD, $message);
		$message = str_replace($symbol."7", TextFormat::GRAY, $message);
		$message = str_replace($symbol."8", TextFormat::DARK_GRAY, $message);
		$message = str_replace($symbol."9", TextFormat::BLUE, $message);
        //Letters
		$message = str_replace($symbol."a", TextFormat::GREEN, $message);
		$message = str_replace($symbol."b", TextFormat::AQUA, $message);
		$message = str_replace($symbol."c", TextFormat::RED, $message);
		$message = str_replace($symbol."d", TextFormat::LIGHT_PURPLE, $message);
		$message = str_replace($symbol."e", TextFormat::YELLOW, $message);
		$message = str_replace($symbol."f", TextFormat::WHITE, $message);
        //Special
		$message = str_replace($symbol."k", TextFormat::OBFUSCATED, $message);
		$message = str_replace($symbol."l", TextFormat::BOLD, $message);
		$message = str_replace($symbol."m", TextFormat::STRIKETHROUGH, $message);
		$message = str_replace($symbol."n", TextFormat::UNDERLINE, $message);
		$message = str_replace($symbol."o", TextFormat::ITALIC, $message);
		$message = str_replace($symbol."r", TextFormat::RESET, $message);
	
		return $message;
	}
    /*
    MOTD On Player Join
    */
    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        var_dump($this->getConfig()->get("joinmessages"));
    }
    /*
    Anti-Kick/Ban OP
    */
    public function onKick(PlayerKickEvent $event){
			$player = $event->getPlayer();
			if($player->isOp()){$event->setCancelled(true);}
    }
    /*
    Auto Broadcast
    */
    public function broadcast($conf, $message){
		$message = str_replace("{MAXPLAYERS}", $this->getServer()->getMaxPlayers(), $message);
		$message = str_replace("{TOTALPLAYERS}", count($this->getServer()->getOnlinePlayers()), $message);
		$message = str_replace("{PREFIX}", $conf["prefix"], $message);
		return $message;
	}
	
	public function getMessagefromArray($array){
		unset($array[0]);
		return implode(' ', $array);
	}
    /*
    Auto Popups
    */
    public function broadcastPopup($conf, $message){
		$message = str_replace("{MAXPLAYERS}", $this->getServer()->getMaxPlayers(), $message);
		$message = str_replace("{TOTALPLAYERS}", count($this->getServer()->getOnlinePlayers()), $message);
		$message = str_replace("{PREFIX}", $conf["prefix"], $message);
		return $message;
	}
    /*
    TODO: SocialSpy
    */
    public function onTell(PlayerCommandPreProcessEvent $event){
        $command = explode(" ", strtolower($event->getMessage()));
        if($command[0] === "/tell"){
        if($p->isOnline() && $p->isOp()){
        $p->sendMessage(TextFormat::DARK_RED."[SS] ".TextFormat::WHITE.$sender->getName()."->".TextFormat::WHITE.$receive->getName($args).TextFormat::WHITE.$this->getMsg($args));
        return true;
        }
    }
    }
    /*
    ADDITION: Command Logger For SocialSpy? (Logs to commands.log)
    */
    /*
    READD: Kick/Tempban On Player Death (Kick, Or 5min Tempban?)
    */
}
