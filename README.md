# MVC kurs repo

![BTH](https://dbwebb.se/image/theme/leaf_256x256.png)

## Om innehållet
Repot innehåller den kod som utvecklas i kursen 
[MVC](https://dbwebb.se/kurser/mvc-v2).

MVC Står för (V)iews, (C)ontrollers. Oklart vad (M) står för :smile:


## Klona repot
```bash
cd <whatever dir>
git clone https://github.com/pebe22-bth/mvc
```
## Fontawesome
Fonter - dvs några brand-ikoner bl.a. github icon ligger inte med i repot utan det behövs access till mitt kit på fontawesome.com.
Så länge du kör på en webplats med privat IP (10.*, 192.168.*) eller *.bth.se så kommr det fungera, men inte annars.
Du kan enkelt registrera ditt eget kit på fontawesome där du inkluderar "brands" free styles och uppdatera
base.html.twig
```
<script src="https://kit.fontawesome.com/<ditt unika id>
```
om du har behov att köra på annan domän.

## Komma igång 
```bash
npm run build
```
- starta valfri php-enabled webserver. Är det bara din lokala utvecklingsmiljö så kan symfonys server funka utmärkt:
```bash
symfony server:start --allow-all-ip
```

## Ramverk
[Symfony](https://symfony.com/)

