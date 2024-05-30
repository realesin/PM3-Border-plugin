<?php

namespace Border;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\level\Position;
use pocketmine\level\sound\EndermanTeleportSound;
use pocketmine\event\player\PlayerMoveEvent;
use Border\Main;

class Main extends PluginBase implements Listener {
    
    public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		@mkdir($this->getDataFolder());
		$this->saveDefaultConfig();
		$this->getResource("config.yml");
    }

    public function onBorder(PlayerMoveEvent $event){
        $player = $event->getPlayer();
        $x = $player->getX();
        $y = $player->getY();
        $z = $player->getZ();
        if($player->getLevel()->getFolderName() === $this->getConfig()->get("size")){
            $size = $this->getServer()->getDefaultLevel()->getSpawnLocation()->distance($player);
            if($size >= $this->getConfig()->get("size")){
				$player->setGamemode(0);
				$player->setAllowFlight(false);
				$player->getLevel()->addSound(new EndermanTeleportSound($player));
                $player->setMotion(new Vector3(-1.5, 1, 0));
                $player->sendMessage($this->getConfig()->get("message"));
            }
        }
    }
}