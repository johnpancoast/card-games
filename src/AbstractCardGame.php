<?php
/**
 * @package johnpancoast/card-games
 * @copyright (c) 2015 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\CardGames;

use Pancoast\CardGames\People\PlayerCollection;
use Pancoast\CardGames\PlayerInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @todo Add description
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
abstract class AbstractCardGame implements CardGameInterface
{
    /**
     * @var PlayerCollection
     */
    private $players;

    /**
     * @var StepCollectionInterface
     */
    private $stepCollection;

    /**
     * @var OutputInterface Program output
     */
    private $output;

    /**
     * Is game presently active
     *
     * @todo Maybe introduce more states but this works for now
     * @var bool
     */
    private $isActive = false;

    /**
     * @return StepCollectionInterface
     */
    abstract public function getStepCollection();

    /**
     * Constructor
     */
    public function __construct(OutputInterface $output)
    {
        $this->players = new PlayerCollection();
        $this->stepCollection = $this->getStepCollection();
        $this->output = $output;
    }

    /**
     * @inheritDoc
     */
    public function addPlayer(PlayerInterface $player)
    {
        $this->players->addPlayer($player);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function createPlayer()
    {
        return $this->players->createPlayer();
    }

    /**
     * @inheritDoc
     */
    public function getPlayer($uniqueId)
    {
        return $this->players->get($uniqueId);
    }

    /**
     * @inheritDoc
     */
    public function play()
    {
        $this->isActive = true;

        while ($this->isGameActive()) {
            foreach ($this->stepCollection as $step) {
                call_user_func_array($step, [$this, $this->output]);
            }

            $this->isActive = false;
        }
    }

    /**
     * @inheritDoc
     */
    public function isGameActive()
    {
        return $this->isActive;
    }
}
