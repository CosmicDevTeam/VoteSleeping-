<?php

namespace zephy\sleep;
use pocketmine\utils\SingletonTrait;
use pocketmine\plugin\PluginBase;
use zephy\sleep\listener\BedListener;
class Loader extends PluginBase {
   use SingletonTrait;
   protected function onEnable(): void {
     self::setInstance($this);
     $this->getServer()->getPluginManager()->registerEvents(new BedListener(), $this);
   }
}
