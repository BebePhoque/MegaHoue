<?php

namespace megahoue;

use pocketmine\block\Block;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;
use pocketmine\level\Position;

class Main extends PluginBase implements Listener
{
    private $WorldGuard;
    public function onEnable()
    {
        $this -> getServer() -> getPluginManager() -> registerEvents($this, $this);
        $this->WorldGuard = $this->getServer()->getPluginManager()->getPlugin("WorldGuard");
    }

    #60:0 Terre Oué
    #370:0 Larme de ghast

    /**
     * @priority LOWEST
     * @param PlayerInteractEvent $event
     * @return void
     */
    public function seedPlanter(PlayerInteractEvent $event){
        $block = $event->getBlock();
        $position = new Position($block->x, $block->y, $block->z, $block->getLevel());
        if (($region = $this->WorldGuard->getRegionFromPosition($position)) !== "") {
            return true;
        }
        $item = $event->getItem();
        $block = $event->getBlock();
        if ($item -> getId() === 294) {
            $this->changerTerre($block, 1);
        }
    }

    /**
     * @priority LOWEST
     * @param BlockBreakEvent $event
     * @return void
     */
    public function rePlanter(BlockBreakEvent $event){
        $block = $event->getBlock();
        $position = new Position($block->x, $block->y, $block->z, $block->getLevel());
        if (($region = $this->WorldGuard->getRegionFromPosition($position)) !== "") {
            return;
        }
        $item = $event->getItem();
        $block = $event->getBlock();
        if ($item -> getId() === 294) {
            $event->setCancelled(true);
            $this->ChangerGraine($block, 1);
        }
    }

    public function changerTerre($block, $Contour)
    {
        $minposx = $block -> x - $Contour;
        $maxposx = $block -> x + $Contour;
        $minposz = $block -> z - $Contour;
        $maxposz = $block -> z + $Contour;
        $y = $block -> y;
        for ($x = $minposx; $x <= $maxposx; $x++) {
            for ($z = $minposz; $z <= $maxposz; $z++) {
                $terrehoue = Block::get(60, 0);
                $terre = $block->getLevel()->getBlockAt($x, $y, $z);
                if ($terre->getId() === 3) {
                    $block->getLevel()->setBlock(new Vector3($x, $y, $z), $terrehoue);
                }
                if ($terre->getId() === 2){
                    $block->getLevel()->setBlock(new Vector3($x, $y, $z), $terrehoue);
                }
            }
        }
    }

    public function ChangerGraine($block, $Contour)
    {
        $minposx = $block -> x - $Contour;
        $maxposx = $block -> x + $Contour;
        $minposz = $block -> z - $Contour;
        $maxposz = $block -> z + $Contour;
        $y = $block -> y;
        for ($x = $minposx; $x <= $maxposx; $x++) {
            for ($z = $minposz; $z <= $maxposz; $z++) {
                $item = Item::get(Item::AIR);
                $terre = $block->getLevel()->getBlockAt($x, $y, $z);
                if($terre->getId() === 59 and $terre->getDamage() === 7){
                    $terre->getLevel()->useBreakOn($terre, $item);
                    $block->getLevel()->setBlock(new Vector3($x, $y, $z), Block::get(59,0));
                }
                if($terre->getId() === 244 and $terre->getDamage() === 7){
                    $terre->getLevel()->useBreakOn($terre, $item);
                    $block->getLevel()->setBlock(new Vector3($x, $y, $z), Block::get(244,0));
                }
                if($terre->getId() === 141 and $terre->getDamage() === 7){
                    $terre->getLevel()->useBreakOn($terre, $item);
                    $block->getLevel()->setBlock(new Vector3($x, $y, $z), Block::get(141,0));

                }
                if($terre->getId() === 142 and $terre->getDamage() === 7){
                    $terre->getLevel()->useBreakOn($terre, $item);
                    $block->getLevel()->setBlock(new Vector3($x, $y, $z), Block::get(142,0));

                }
            }
        }
    }

}