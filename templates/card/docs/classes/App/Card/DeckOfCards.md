
## DeckOfCards

DeckOfCards - represents a deck of Cards



* Full name: `\App\Card\DeckOfCards` 



## Properties


### deck



```php
private $deck
```






***

## Methods


### __construct



```php
public __construct(): mixed
```












***

### buildDeck

buildDeck - fills the deck with 52 cards

```php
private buildDeck(): void
```












***

### shuffle

shuffle - shuffles the deck of cards

```php
public shuffle(): void
```












***

### drawCard

drawCard -

```php
public drawCard(): \App\Card\CardGraphic
```












***

### getNumberOfCards

getNumberOfCards - returns the number of remaining cards in the deck

```php
public getNumberOfCards(): int
```












***

### getDeckAsValues

getDeckAsValues - returns the values of the cards in the deck

```php
public getDeckAsValues(): array
```












***

### getDeck

getDeck - returns the string representation of the cards in the deck

```php
public getDeck(): array
```












***


