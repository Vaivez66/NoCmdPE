<?php

namespace Vaivez66\NoCmdPE;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\CommandExecutor;
use pocketmine\Server;
use pocketmine\utils\TextFormat as TF;
use pocketmine\utils\Config;

class NoCmd extends PluginBase implements Listener{

    public $cfg;
    private $cmd = [];
    private $format;
    
    public function onEnable(){
        $this->saveDefaultConfig();
        $this->getLogger()->info(TF::GREEN . "NoCmdPE was enabled!");
        $this->getServer()->getPluginManager()->registerEvents(new NoCmdListener($this), $this);
        $this->getCommand("nocmd")->setExecutor(new NoCmdCommand($this));
        $this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML, array());
        $this->format = new NoCmdFormat($this);
    }

    /**
     * @return array
     */

    public function getCmd(){
        $this->cmd = $this->cfg->get("commands");
        return $this->cmd;
    }

    /**
     * @param $p
     * @param $m
     * @return mixed
     */

    public function runCmd($p, $m){
        return $this->getServer()->dispatchCommand($p, $m);
    }
    
    /**
     * @return mixed
     */
    	
    public function getFormat(){
    	return $this->format;
    }

}
