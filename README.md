card-games
==========
A collection of card games starting with a mini/basic version of texas hold 'em.

*This is just for academic purposes...*

Install
-------
card-games uses [composer](https://getcomposer.org/) so you must [install](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx) that first.
 
From the base directory, run the following to install dependencies.
```
composer install
```

Usage
-----
```
./bin/games [game] [options]
```

At present, the only game is a mini version of Texas Hold 'Em which you can run with the following:

```
./bin/games texas-holdem [amount of player]
```