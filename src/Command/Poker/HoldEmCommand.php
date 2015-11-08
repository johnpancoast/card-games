<?php
/**
 * @package johnpancoast/card-games
 * @copyright (c) 2015 John Pancoast
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @license MIT
 */

namespace Pancoast\CardGames\Command\Poker;

use Pancoast\CardGames\Game\Poker\HoldEm;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @todo Add description
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class HoldEmCommand extends Command
{
    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setName('texas-holdem')
            ->setDescription("Texas Hold 'Em")
            ->addArgument(
                'player_count',
                InputArgument::REQUIRED,
                'How many players are in the game'
            )
        ;
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $playerCount = $input->getArgument('player_count');

        $game = new HoldEm($output);

        for ($i = 0; $i < $playerCount; $i++) {
            $game->createPlayer();
        }

        $game->play();
    }
}