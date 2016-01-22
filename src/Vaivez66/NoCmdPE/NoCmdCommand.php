<?php

namespace Vaivez66\NoCmdPE;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\utils\TextFormat as TF;
use Vaivez66\NoCmdPE\NoCmd;

class NoCmdCommand extends PluginBase implements CommandExecutor{

    public function __construct(NoCmd $plugin){
        $this->plugin = $plugin;
    }

    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
        $cmds = $this->plugin->getCmd();
        foreach($cmds as $c){
            switch(strtolower($cmd->getName())){
                case "nocmd":
                    if(isset($args[0])){
                        switch($args[0]){
                            case "list":
                                if($sender->hasPermission("no.cmd.list")){
									$sender->sendMessage(TF::GREEN . "Available commands:");
                                    for($c = 0; $c < count($cmds); $c++){
                                        $sender->sendMessage(TF::YELLOW . "- " . $cmds[$c]["name"]);
									}
									return true;
                                }
								else{
                                    $sender->sendMessage(TF::RED . "You do not have permissions for this command");
									return true;
                                }
                                break;
							case "reload":
							    if($sender->hasPermission("no.cmd.reload")){
									$this->plugin->cfg->reload();
									$sender->sendMessage(TF::GREEN . "Config reloaded!");
									return true;
								}
								else{
									$sender->sendMessage(TF::RED . "You do not have permissions for this command");
									return true;
								}
								break;
                        }
                    }
                    break;
            }
        }
    }

}