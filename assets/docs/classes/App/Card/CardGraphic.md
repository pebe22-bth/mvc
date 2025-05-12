
# CardGraphic

CardGraphic represents a playing card represented as a string conaining color and value (2 characters)



* Full name: `\App\Card\CardGraphic` 
* Parent class: [`\App\Card\Card`](./Card.md)



## Properties


### colors

colors

```php
private array $colors
```






***

### values

values

```php
private array $values
```






***

### representation

representation

```php
private array $representation
```






***

## Methods


### __construct

__construct sets the value of the card to null

```php
public __construct(): void
```












***

### buildArrayOfCards

buildArrayOfCards

```php
private buildArrayOfCards(): void
```









**Return Value:**

Builds the array of card representation based on color and value




***

### getAsString

getAsString

```php
public getAsString(): string
```









**Return Value:**

The value of the card as a graphical string




***


## Inherited methods


### __construct

__construct sets the value of the card to null

```php
public __construct(): void
```












***

### set

set sets the value of the card

```php
public set(mixed $value): int
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | **mixed** |  |


**Return Value:**

The value of the card that was just set




***

### getValue

getValue returns the value of the card

```php
public getValue(): int
```









**Return Value:**

The value of the card




***

### getAsString

getAsString returns the value of the card as a string

```php
public getAsString(): string
```









**Return Value:**

The value of the card as a string




***


