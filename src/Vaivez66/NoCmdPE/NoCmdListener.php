<?php

namespace Vaivez66\NoCmdPE;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\utils\TextFormat as TF;
use Vaivez66\NoCmdPE\NoCmd;

class NoCmdListener extends PluginBase implements Listener{

    public function __construct(NoCmd $plugin){
        $this->plugin = $plugin;
    }

    public function onChat(PlayerChatEvent $event){
        $player = $event->getPlayer();
        $msg = $event->getMessage();
        $m = explode(" ", $msg);
        $cmds = $this->plugin->getCmd();
        foreach($cmds as $cmd){
            $default = $cmd["default"];
            $permission = $cmd["permission"];
            $noperm = $cmd["no-permission"];
			$noperm = $this->plugin->getFormat()->translate($noperm);
            $name = $cmd["name"];
            if(strtolower($m[0]) == strtolower($name)){
                if($permission != null){
                    switch($default){
                        case true:
                            $event->setCancelled(true);
                            $this->plugin->runCmd($player, $msg);
                            break;
                        case false:
                            if($player->hasPermission($permission)){
                                $event->setCancelled(true);
                                $this->plugin->runCmd($player, $msg);
                            }
                            else{
                                $event->setCancelled(true);
                                $player->sendMessage($noperm);
                            }
							break;
                    }
				}
                else{
					$event->setCancelled(true);
                    $player->sendMessage(TF::RED . "Permission for this action hasn't been setted up");
                }
            }
        }
    }

}