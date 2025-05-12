
# DiceGameController





* Full name: `\App\Controller\DiceGameController` 
* Parent class: [`AbstractController`](#content-abstractcontroller)




## Methods


### home



```php
public home(): \Symfony\Component\HttpFoundation\Response
```












***

### testRollDice



```php
public testRollDice(): \Symfony\Component\HttpFoundation\Response
```












***

### testRollDices



```php
public testRollDices(int $num): \Symfony\Component\HttpFoundation\Response
```








| Parameter | Type | Description |
|-----------|------|-------------|
| `$num` | **int** |  |





***

### testDiceHand



```php
public testDiceHand(int $num): \Symfony\Component\HttpFoundation\Response
```








| Parameter | Type | Description |
|-----------|------|-------------|
| `$num` | **int** |  |





***

### init



```php
public init(): \Symfony\Component\HttpFoundation\Response
```












***

### initCallback



```php
public initCallback(\Symfony\Component\HttpFoundation\Request $request, \Symfony\Component\HttpFoundation\Session\SessionInterface $session): \Symfony\Component\HttpFoundation\Response
```








| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | **\Symfony\Component\HttpFoundation\Request** |  |
| `$session` | **\Symfony\Component\HttpFoundation\Session\SessionInterface** |  |





***

### play



```php
public play(\Symfony\Component\HttpFoundation\Session\SessionInterface $session): \Symfony\Component\HttpFoundation\Response
```








| Parameter | Type | Description |
|-----------|------|-------------|
| `$session` | **\Symfony\Component\HttpFoundation\Session\SessionInterface** |  |





***

### roll



```php
public roll(\Symfony\Component\HttpFoundation\Session\SessionInterface $session): \Symfony\Component\HttpFoundation\Response
```








| Parameter | Type | Description |
|-----------|------|-------------|
| `$session` | **\Symfony\Component\HttpFoundation\Session\SessionInterface** |  |





***

### save



```php
public save(\Symfony\Component\HttpFoundation\Session\SessionInterface $session): \Symfony\Component\HttpFoundation\Response
```








| Parameter | Type | Description |
|-----------|------|-------------|
| `$session` | **\Symfony\Component\HttpFoundation\Session\SessionInterface** |  |





***


