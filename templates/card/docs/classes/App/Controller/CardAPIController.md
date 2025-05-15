
## CardAPIController

CardAPIController - defines the JSON API endpoints for the Card game



* Full name: `\App\Controller\CardAPIController` 




## Methods


### deck

deck - Creates a new deck of cards and returns it

```php
public deck(\Symfony\Component\HttpFoundation\Session\SessionInterface $session): void
```








| Parameter | Type | Description |
|-----------|------|-------------|
| `$session` | **\Symfony\Component\HttpFoundation\Session\SessionInterface** |  |





***

### shuffle

shuffle - Shuffles an existing deck of cards and returns it

```php
public shuffle(\Symfony\Component\HttpFoundation\Session\SessionInterface $session): void
```








| Parameter | Type | Description |
|-----------|------|-------------|
| `$session` | **\Symfony\Component\HttpFoundation\Session\SessionInterface** |  |





***

### draw

draw - Draws a card from the deck and returns it

```php
public draw(\Symfony\Component\HttpFoundation\Session\SessionInterface $session): void
```








| Parameter | Type | Description |
|-----------|------|-------------|
| `$session` | **\Symfony\Component\HttpFoundation\Session\SessionInterface** |  |





***

### draw_multiple

draw_multiple - draws multiple cards from the deck and returns them

```php
public draw_multiple(int $num, \Symfony\Component\HttpFoundation\Session\SessionInterface $session): void
```








| Parameter | Type | Description |
|-----------|------|-------------|
| `$num` | **int** |  |
| `$session` | **\Symfony\Component\HttpFoundation\Session\SessionInterface** |  |





***


