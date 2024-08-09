<?php

namespace zephy\sleep;

use pocketmine\plugin\PluginBase;
use zephy\sleep\listener\BedListener;
class Loader extends PluginBase {
   protected function onEnable(): void {
     $this->getServer()->getPluginManager()->registerEvents(new BedListener(), $this);
   }
}
