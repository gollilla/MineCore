<?php

   /**  
    *   __  __ _               ____               
    *  |  \/  (_)_ __   ___   / ___|___  _ __ ___ 
    *  | |\/| | | '_ \ / _ \ | |   / _ \| '__/ _ \
    *  | |  | | | | | |  __/ | |__| (_) | | |  __/
    *  |_|  |_|_|_| |_|\___|  \____\___/|_|  \___|
    *
    *
    *   @author soradore
    *
    **/                                         

namespace soradore\minecore;


/* Base */
use pocketmine\plugin\PluginBase;

/* Events */
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\QuitEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\block\BlockBreakEvent;


/* Save */
use pocketmine\utils\Config;

/* Item and Block */
use pocketmine\item\Item;
use pocketmine\block\Block;

/* Level and Math */
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\math\Vector3;

class main extends PluginBase implements Listener{

    //@var array  $core    core HP 
    public $core = [];

    //@var array  $players team
    public $players = [];

    //@var Config $config
    public $config = null;

    //@var API  $api  | Web Api Client |
    public $api = null;

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        if(!file_exists($this->getDataFolder()){
            mkdir($this->getDataFolder(), 0744, true);
        }
        $this->config = new Config($this->getDataFolder().'config.yml', Config::YAML, []);
        $this->api = new API();
    }

    public function onJoin(PlayerJoinEvent $ev){
        $player = $ev->getPlayer();
        $player->getInventory()->clearAll();
        $this->healAll($player);
        $this->setNameTag($player);
    }

    public function onTouch(PlayerInteractEvent $ev){
        $player = $ev->getPlayer();
        $block = $ev->getBlock();
        if($this->isJoinBlock($block)){
            if($player->isPlayer($player)){
                $player->sendMessage(self::getMessage('player.cant.join'));
                return false;
            }
            $this->joinGame($player);
            $player->sendMessage(self::getMessage('player.joined')); 
        }
        return true;
    }

 
    /**
     * @param  Player $player
     * @return void
     */

    public function setNameTag(Player $player){
        $name = $player->getName();
        if($this->isPlayer($player)){
            $team = $this->getTeam($player);
            $colors = ['§a', '§b'];
            $tag = $colors[$team];
            $name = "{$tag}{$name}";
        }
        $level = $this->getPlayerLevel($player);
        $name .= "§e|§f ".$level;
        
        $player->setNameTag($name);
    }    


    /**
     * @param  Player  $player 
     * @param  string  $option  Option | 'name' |
     * @return boolean $return
     * @return string  $return
     * @return int     $return
     */

    public function getTeam(Player $player, $option = false){
        $name = $player->getName();
        $return = '';
        if($option){
            if(in_array($this->players['red'], $name)){
                $return = 'red';
            }elseif(in_array($this->players['blue'], $name)){
                $return = 'blue';
            }else{
                $return = false;
            }
            return $return;
        }
        if(in_array($this->players['red'], $name)){
            $return = 0;
        }elseif(in_array($this->players['blue'], $name)){
            $return = 1;
        }else{
            $return = false;
        }
        return $return;
        
    }  

 
    /**
     * @param  Player  $player
     * @return boolean
     */

    public function isPlayer(Player $player){
        $players = $this->getPlayers(); 
        $name = $player->getName();
        return in_array($players, $name);
    }


    /**
     * @param  Block   $block
     * @return boolean
     */ 

    public function isJoinBlock(Block $block){
        //TODO
    }

    public function getPlayers(){
        $array = array_merge($this->players['red'], $this->players['blue']); 
        return $array;
    }
}