<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\DeckOfCards;
use App\Card\CardHand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card_start")]
    public function home(
        SessionInterface $session
    ): Response {
        $session->set("status", "Started");

        return $this->render('card/home.html.twig');
    }
    #[Route("/card/deck", name: "card_deck")]
    public function deck(
        SessionInterface $session
    ): Response {

        $deck = new DeckOfCards();

        $session->set("card_deck", $deck);
        $data = [
            "deck" => $deck->getDeck()
        ];

        return $this->render('card/deck.html.twig', $data);
    }
    #[Route("/card/deck/shuffle", name: "card_deck_shuffle")]
    public function shuffle(
        SessionInterface $session
    ): Response {
        $deck = $session->get("card_deck");
        if ($deck === null || $deck->getNumberOfCards() < 52) {
            $session->clear("card_deck");
            $deck = new DeckOfCards();
        }
        $deck->shuffle();
        $session->set("card_deck", $deck);
        $data = [
            "deck" => $deck->getDeck()
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "card_deck_draw")]
    public function draw(
        SessionInterface $session
    ): Response {
        $cardsStr = [];
        $deck = $session->get("card_deck");
        if ($deck == null) {
            throw new \Exception("Ingen kortlek finns. Skapa en ny kortlek innan du drar ett kort.");
        }

        $card = $deck->drawCard();
        $cardsStr[] = $card->getAsString();
        $session->set("card_deck", $deck);
        $data = [
            "cardsStr" => $cardsStr,
            "cards_left" => $deck->getNumberOfCards()
        ];

        return $this->render('card/cards.html.twig', $data);
    }
    #[Route("/card/deck/draw/{num<\d+>}", name: "card_deck_draw_multiple")]
    public function draw_multiple(
        int $num,
        SessionInterface $session
    ): Response {
        $deck = $session->get("card_deck");

        if ($deck == null) {
            throw new \Exception("Ingen kortlek finns. Skapa en ny kortlek innan du drar ett kort.");
        }
        $cardsleft = $deck->getNumberOfCards();
        if ($num > $cardsleft) {
            throw new \Exception("Du kan inte dra fler kort än det finns kvar i kortleken! (" . $cardsleft . " st)");
        }
        $cards = [];
        $cardsStr = [];
        for ($i = 0; $i < $num; $i++) {
            $cards[] = $deck->drawCard();
            $cardsStr[] = $cards[$i]->getAsString();
        }
        $session->set("card_deck", $deck);
        $data = [
            "cardsStr" => $cardsStr,
            "cards_left" => $deck->getNumberOfCards()
        ];

        return $this->render('card/cards.html.twig', $data);
    }
    #[Route("/card/deck/cardsleft", name: "cardsleft")]
    public function cardsleft(
        SessionInterface $session
    ): Response {
        $deck = $session->get("card_deck");

        $data = [
            "deck" => $deck->getDeck(),
            "cards_left" => $deck->getNumberOfCards()
        ];

        return $this->render('card/cardsleft.html.twig', $data);
    }


    #[Route("/session", name: "session")]
    public function session(
        SessionInterface $session
    ): Response {
        date_default_timezone_set('CET');
        $session->set("last_check", date('D M j G:i:s T Y'));
        $sessionMetadata = $session->getMetadataBag();

        $sessionData = $session->all();

        $metaData = [
            "Created" => date('D M j G:i:s T Y', $sessionMetadata->getCreated()),
            "Last used" => date('D M j G:i:s T Y', $sessionMetadata->getLastUsed()),
            "Lifetime (seconds, where 0 = none)" => $sessionMetadata->getLifetime()
        ];

        $data = [
            "sessionData" => $sessionData,
            "metaData" => $metaData
        ];

        return $this->render('session.html.twig', $data);
    }
    #[Route("/session/delete", name: "session_delete")]
    public function deleteSession(
        SessionInterface $session
    ): Response {
        $session->clear();
        $this->addFlash(
            'notice',
            'Session deleted!'
        );
        return $this->redirectToRoute('session');
    }

}
