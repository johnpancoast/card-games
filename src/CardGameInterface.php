<?php
/**
 * @package johnpancoast/card-games
 * @copyright (c) 2015 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\CardGames;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @todo Add description
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface CardGameInterface
{
    /**
     * Add a player
     *
     * @param PlayerInterface $player
     * @throws PlayerAlreadyExistsException If player already exists
     * @throws GameLogicException If adding this player does not make sense for the game
     * @return $this
     */
    public function addPlayer(PlayerInterface $player);

    /**
     * Create and add player
     *
     * @throws GameLogicException If adding this player does not make sense for the game
     * @return PlayerInterface
     */
    public function createPlayer();

    /**
     * Get player
     *
     * @param $uniqueId of the player you want to get
     * @return mixed
     */
    public function getPlayer($uniqueId);

    /**
     * Get all players
     *
     * @return PlayerCollectionInterface
     */
    public function getPlayers();

    /**
     * Core logic of the game
     *
     * @throws GameLogicException If something about game is not right
     */
    public function play();

    /**
     * Is the game active
     *
     * @return bool
     */
    public function isGameActive();
}