<?php

namespace zephy\sleep\cache;

use pocketmine\player\Player;
use pocketmine\world\World;
use pocketmine\utils\SingletonTrait;

class WeakPlayer {
   use SingletonTrait;
   private array $weakplayer = [];
   
   public function setSleeping(Player $player): void{
      $this->weakplayer[$player->getName()] = $player->getWorld()->getId();
   }
   
   public function isSleeping(Player $player): bool{
      return isset($this->weakplayer[$player->getName()]);
   }
   public function getPlayersSleeping(): array {
      return $this->weakplayer;
   }
   public function unsetSleeping(Player $player): void {
      unset($this->weakplayer[array_search($player->getName(), $this->weakplayer)]);
   }
   
   public function getPlayersSleepingAtWorld(World $world): ?array{
      $players = [];
      
      foreach($this->getPlayersSleeping() as $player => $id){
         if($id === $world->getId()){
            $players[] = $player;
         }
      }
      if(count($players) === 0){
         return null;
      }
      return $players;
   }
}
