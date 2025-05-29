<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Card\Game21;
use Exception;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * CardAPIController - defines the JSON API endpoints for cheings status of the 21 game.
 * Requires a session cookie with the ongoing game to be provided if not using the same same browser.
 */
class GameAPIController
{
    #[Route("/api/game", name: "api_game", methods: ['GET'])]
    public function game(
        SessionInterface $session
    ): Response {

        $game = $session->get("game");
        if (($game instanceof Game21) === false) {
            throw new Exception("Game not found in session, starting a new game.");
        }

        $playerHand = $game->getPlayerHand();
        $handValue = $game->getHandValue($playerHand);
        $bankHand = $game->getBankHand();
        $bankHandValue = $game->getHandValue($bankHand);
        $turn = $game->getTurn();
        $winner = $game->getWinner();

        $data = [
            "player_hand" => $playerHand->getString(),
            "player_handValue" => $handValue,
            "bank_hand" => $bankHand->getString(),
            "bank_handValue" => $bankHandValue,
            "turn" => $turn,
            "winner" => $winner
            ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

}
