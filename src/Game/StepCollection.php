<?php
/**
 * @package johnpancoast/card-games
 * @copyright (c) 2015 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\CardGames\Game;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @todo Add description
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class StepCollection extends ArrayCollection implements StepCollectionInterface
{
    /**
     * @inheritDoc
     * @defunct
     */
    public function set($key, $value)
    {
        throw new \LogicException('Step collections are collections without keys (as in, indexed, non-associative arrays). Use StepCollection::addStep().');
    }

    /**
     * @inheritDoc
     */
    public function addStep(callable $step)
    {
        $this->add($step);
    }
}