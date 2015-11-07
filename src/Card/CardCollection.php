<?php
/**
 * @package johnpancoast/card-games
 * @copyright (c) 2015 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\CardGames\Card;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @todo Add description
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class CardCollection extends ArrayCollection implements CardCollectionInterface
{
    /**
     * @inheritDoc
     */
    public function addCard(CardInterface $card)
    {
        $this->add($card);
    }
}