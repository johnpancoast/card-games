<?php
/**
 * @package johnpancoast/card-games
 * @copyright (c) 2015 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\CardGames\Game;

use Doctrine\Common\Collections\Collection;

/**
 * @todo Add description
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface StepCollectionInterface extends Collection
{
    /**
     * Add step
     *
     * $step can be any callable with the following signature:
     *
     *    @#param Pancoast\CardGames\CardGameInterface $cardGame The card game
     *    @#param \Symfony\Component\Console\Input\OutputInterface $output For writing output
     *    @#throws GameLogicException If something about the game is not right when the step is called
     *    @#return bool Successful?
     *
     * That is to say, the callable will receive a CardGameInterface implementation, it will run whatever
     * logic it needs on the game, then return if it was successful (or throw an exception if something
     * exceptional happened).
     *
     * @param callable $step
     */
    public function addStep(callable $step);
}