card-games
==========
A collection of card games starting with texas hold 'em.

Hold-em Objective
-----------------
*Todo - fix structure*

The objective is to write a PHP CLI (no GUI) program that simulates a card game of texas hold’em poker.

The input of the program should be the number of players. The program should deal 2 “hole” cards to each

player and 5 “community” cards. Using each player’s hole cards combined with the community cards,

determine the best possible 5­card hand each player has, rank the hands, and determine the winner. The

output of the program should list each player’s hand and identify which player has the winning hand. The

rules for hand ranking are as follows, ordered from lowest to highest:

High­Card Hand – A hand containing five unmatched cards, that is, lacking any of the combinations shown

below, is valued by its highest ranking card. The highest card is Ace.

One Pair – Two cards of equal rank and three unmatched cards. Example: 5­5­8­J­K. If two players are

competing with one­pair hands, then the higher ranked of the pairs­aces highest, deuces lowest­wins the

pot. And if two players have the same pair, then the highest side card would be used to determine the

higher­ranking hand. 5­5­A­7­6 beats 5­5­K­Q­J, since the ace is a higher kicker than the king.

Two Pair – Two pairs and an unmatched card. Example: 6­6­J­J­2. The highest pair of competing two­pair

hands will win, or if the top pair is tied, then the second pair. If both pairs are equivalent, then the fifth card

decides the winner. K­K­3­3­6 beats J­J­8­8­Q and K­K­2­2­ A, but loses to K­K­3­3­9alright I

Three of a Kind – Three cards of equal rank and two unmatched cards. Also called trips or a set. Example:

Q­Q­Q­7­J. If two players hold a set, the higher ranked set will win, and if both players hold an equivalent

set, then the highest odd card determines the winner. 7­7­ 7­4­2 beats 5­5­5­A­K, but loses to 7­7­7­9­5.

Straight – Five cards of mixed suits in sequence, but it may not wrap around the ace. For example,

Q­J­10­9­8 of mixed suits is a straight,

but Q­K­A­2­3 is not, it’s simply an ace­high hand. If two players hold straights, the higher straight card at

the top end of the sequence will win. J­10­9­8­7 beats 5­4­3­2­A but would tie another player holding

J­10­9­8­7.

Flush – Five cards of the same suit. Example: K­10­9­5­3, all in diamonds. If two players hold flushes, the

player with the highest untied card wins. Suits have no relevance. Thus, Q­J­7­5­4 of diamonds beats

Q­J­4­3­2 of spades.

Full House – Three of a kind and a pair. Example: 5­5­5­9­9. If two players hold full houses, the player with

the higher three of a kind wins. J­J­J­8­8 beats 7­7­7­A­A.

Four of a Kind – Four cards of equal rank and an odd card. Also called quads. Example: K­K­K­K­3. If two

players hold quads, the higher ranking quad will win the hand. K­K­K­K­3 beats 7­7­7­7­A and K­K­K­K­2.

Straight Flush – Five cards in sequence, all in the same suit. Example: 7­ 6­5­4­3, all in spades. If two

straight flushes are competing, the one with the highest card wins.

Royal Flush – The A­K­Q­J­10 of the same suit, the best hand possible. No royal flush is higher than

another.