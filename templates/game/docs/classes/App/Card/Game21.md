
## Game21

Game21 represents the 21 card game with a dealer that always draws to 17.



* Full name: `\App\Card\Game21` 



## Properties


### bankHand



```php
private $bankHand
```






***

### deck



```php
private $deck
```






***

### playerHand



```php
private $playerHand
```






***

### winner



```php
private $winner
```






***

### turn



```php
private $turn
```






***

### session



```php
private $session
```






***

## Methods


### __construct

__construct sets the value of the card to null

```php
public __construct(): void
```












***

### getHandValue

getHandValue - returns the best value of the hand

```php
public getHandValue(mixed $hand): int
```








| Parameter | Type | Description |
|-----------|------|-------------|
| `$hand` | **mixed** |  |





***

### playerDraw



```php
public playerDraw(): int
```












***

### bankDraw



```php
public bankDraw(): int
```












***

### playerStop

stop - Player stops drawing cards, banks turn

```php
public playerStop(): void
```












***

### getPlayerHand



```php
public getPlayerHand(): mixed
```












***

### getBankHand



```php
public getBankHand(): mixed
```












***

### getTurn



```php
public getTurn(): mixed
```












***

### getWinner

getWinner - returns the winner. If null, the game is active

```php
public getWinner(): void
```












***


