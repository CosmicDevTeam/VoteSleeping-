<?php

namespace zephy\sleep\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\block\Bed;
use pocketmine\world\World;
use zephy\sleep\cache\WeakPlayer;
use pocketmine\Server;
class BedListener implements Listener{
   public function onInteract(PlayerInteractEvent $event){
      $player = $event->getPlayer();
      $block = $event->getBlock();
      
      if($block instanceof Bed){
         if(!$player->isSleeping() && !WeakPlayer::getInstance()->isSleeping($player)) {
            
            $player->sleepOn($block->getPosition()->asVector3());
            WeakPlayer::getInstance()->setSleeping($player);
            $player->sendMessage("§fYou are now sleeping, good night");
            
            $sleepings = WeakPlayer::getInstance()->getPlayersSleepingAtWorld($player->getWorld());
            
            if($sleepings !== null){
               foreach($sleepings as $weak){
                  $splayer = Server::getInstance()->getPlayerExact($weak);
                  $count = count($sleepings);
                  $players = count($player->getWorld()->getPlayers()) / 2;
                  $requerid = round($players);
                  Server::getInstance()->broadcastMessage("§f{$count}/$requerid are sleeping");
                  
                  if($count == $requerid){
                     $player->getWorld()->setTime(World::SUNRISE);
                     $splayer->stopSleep();
                     WeakPlayer::getInstance()->unsetSleeping($splayer);
                     
                  }
               }
            }
         }
      }
   }
   public function onMove(PlayerMoveEvent $event){
      $player = $event->getPlayer();
      
      if($player->isSleeping()){
         $player->stopSleep();
         WeakPlayer::getInstance()->unsetSleeping($player);
      }
   }
}
