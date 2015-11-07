<?php
/**
 * @package johnpancoast/card-games
 * @copyright (c) 2015 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\CardGames\Card;
use Doctrine\Common\Collections\Collection;

/**
 * @todo Add description
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
interface CardCollectionInterface extends Collection
{
    /**
     * Add a card to hand
     *
     * @param CardInterface $card
     * @throws CardInHandException If card is already in user hand
     * @throws GameLogicException If adding card to hand is illegal
     * @return $this
     */
    public function addCard(CardInterface $card);

    /**
     * Remove a card from collection
     *
     * @param CardInterface $card
     * @return mixed
     */
    public function removeCard(CardInterface $card);
}