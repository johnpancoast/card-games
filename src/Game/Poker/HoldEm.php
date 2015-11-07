<?php
/**
 * @package johnpancoast/card-games
 * @copyright (c) 2015 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\CardGames\Game\Poker;

use Pancoast\CardGames\AbstractCardGame;
use Pancoast\CardGames\CardGameInterface;
use Pancoast\CardGames\Game\StepCollection;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @todo Add description
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class HoldEm extends AbstractCardGame
{
    /**
     * @inheritDoc
     */
    public function getStepCollection()
    {
        $collection = new StepCollection();
        $collection->add([$this, 'deal']);
        return $collection;
        // @todo
        //$collection->add(<foo>);
    }

    public function deal(CardGameInterface $cardGame, OutputInterface $output)
    {
        $output->writeln('Cards got dealt!');
    }
}