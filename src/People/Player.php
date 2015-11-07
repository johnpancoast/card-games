<?php
/**
 * @package johnpancoast/card-games
 * @copyright (c) 2015 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\CardGames\People;
use Pancoast\CardGames\Card\CardInterface;
use Pancoast\CardGames\Card\Hand;
use Pancoast\CardGames\Card\HandInterface;

/**
 * @todo Add description
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class Player implements PlayerInterface
{
    /**
     * @var mixed Id
     */
    private $id;

    /**
     * @var HandInterface
     */
    private $hand;

    /**
     * Constructor
     *
     * @param mixed $id
     */
    public function __construct($id = null)
    {
        $this->id = $id ?: uniqid();
        $this->hand = new Hand();
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function setHand(HandInterface $hand)
    {
        $this->hand = $hand;
    }

    /**
     * @inheritDoc
     */
    public function addToHand(CardInterface $card)
    {
        $this->hand->addCard($card);
    }

    /**
     * @inheritDoc
     */
    public function removeFromHand(CardInterface $card)
    {
        $this->hand->removeElement($card);
    }

    /**
     * @inheritDoc
     */
    public function getHand()
    {
        return $this->hand;
    }
}