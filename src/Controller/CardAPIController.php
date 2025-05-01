<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\DeckOfCards;
use App\Card\CardHand;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardAPIController
{
    #[Route("/api/deck", name: "api_deck", methods: ['GET'])]
    public function deck(
        SessionInterface $session
    ): Response {
        $deck = new DeckOfCards();
        $session->set("card_deck", $deck);

        $data = [
            "deck" => $deck->getDeck()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/shuffle", name: "api_deck_shuffle", methods: ['POST'])]
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
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
    #[Route("/api/deck/draw", name: "api_deck_draw", methods: ['POST'])]
    public function draw(
        SessionInterface $session
    ): Response {
        $cardsStr = [];
        $deck = $session->get("card_deck");
        if ($deck == null) {
            $data = [
                "error" => "Ingen kortlek finns. Skapa en ny kortlek innan du drar ett kort."
            ];
        } else {
            $card = $deck->drawCard();
            $cardsStr[] = $card->getAsString();
            $session->set("card_deck", $deck);
            $data = [
                "cardsStr" => $cardsStr,
                "cards_left" => $deck->getNumberOfCards()
            ];
        }
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
    #[Route("/api/deck/draw/{num<\d+>}", name: "api_deck_draw_multiple", methods: ['POST'])]
    public function draw_multiple(
        int $num,
        SessionInterface $session
    ): Response {
        $deck = $session->get("card_deck");

        if ($deck == null) {
            $data = [
                "error" => "Ingen kortlek finns. Skapa en ny kortlek innan du drar ett kort."
            ];
        } else {
            $cardsleft = $deck->getNumberOfCards();
        }
        if ($num > $cardsleft) {
            $data = [
                   "error" => "Du kan inte dra fler kort än det finns kvar i kortleken",
                   "cards_left" => $cardsleft
            ];
        } else {
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
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
