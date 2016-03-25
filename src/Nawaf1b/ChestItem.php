<?php

namespace Nawaf1b;
       
use pocketmine\item\Item;

use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\level\sound\PopSound;

class ChestItem extends PluginBase implements Listener { 
    
    public $toucherschest = 0;

    public function onTouchChest(PlayerInteractEvent $ev){
        
        $this->toucherschest = 0;
        
        if($ev->getBlock()->getId() == 54){
            
            $tile = $ev->getPlayer()->getLevel()->getTile(new Vector3($ev->getBlock()->x,$ev->getBlock()->y,$ev->getBlock()->z));
            $player = $ev->getPlayer();
            foreach ($tile->getInventory()->getContents() as $chest){
                
                $player->getInventory()->addItem(Item::get($chest->getId()));
                
            }
            
            $player->getLevel()->setBlock(new Vector3($ev->getBlock()->x,$ev->getBlock()->y,$ev->getBlock()->z), \pocketmine\block\Block::get(0));
            
            $player->getLevel()->addSound(new PopSound(new Vector3($ev->getBlock()->x,$ev->getBlock()->y,$ev->getBlock()->z)));
            
            $player->sendPopup("Players Touch Chest : ".$this->getTouchersChest());
            
            $this->toucherschest++;
        }
    }
    
    public function getTouchersChest(){
        return $this->toucherschest;
    }
    
    public function onEnable() {
       
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        
        $this->getLogger()->info("Author ChestItem Plugin : Nawaf_Craft1b");
    }
}