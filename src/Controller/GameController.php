<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Card\Game21;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameController extends AbstractController
{
    #[Route("/game", name: "game_home")]
    public function game(): Response
    {

        return $this->render('game/home.html.twig');
    }
    #[Route("/game/doc", name: "game_doc")]
    public function doc(): Response
    {

        return $this->render('game/doc.html.twig');
    }
    #[Route("/game/start", name: "game_start")]
    public function gameStart(
        SessionInterface $session
    ): Response {

        $game = new Game21();
        $turn = $game->getTurn();
        $this->addFlash(
            'notice',
            'Game restarted!'
        );
        $session->set("game", $game);

        $data = [
            "player_hand" => "",
            "bank_hand" => "",
            "winner" => "",
            "turn" => $turn
        ];

        return $this->render('game/gameboard.html.twig', $data);
    }
    #[Route("/game/player_draw", name: "game_player_draw")]
    public function gamePlayerDraw(
        SessionInterface $session
    ): Response {
        $game = $session->get("game");
        if ($game instanceof Game21 === false) {
            throw new Exception("Game not found in session, starting a new game.");
        }
        $turn = $game->getTurn();
        $handValue = $game->playerDraw();
        $winner = $game->getWinner();
        $session->set("game", $game);
        $playerHand = $game->getPlayerHand();

        $data = [
            "player_hand" =>  $playerHand->getString(),
            "player_handValue" => $handValue,
            "bank_hand" => "",
            "winner" => $winner,
            "turn" => $turn
        ];
        return $this->render('game/gameboard.html.twig', $data);
    }

    #[Route("/game/bank_draw", name: "game_bank_draw")]
    public function gameBankDraw(
        SessionInterface $session
    ): Response {
        $game = $session->get("game");
        if (($game instanceof Game21) === false) {
            throw new Exception("Game not found in session, starting a new game.");
        }
        $game->playerStop();
        $turn = $game->getTurn();
        $playerHand = $game->getPlayerHand();
        $handValue = $game->getHandValue($playerHand);
        $bankHandValue = $game->bankDraw();
        $bankHand = $game->getBankHand();
        $winner = $game->getWinner();
        $session->set("game", $game);


        $data = [

            "player_hand" =>  $playerHand->getString(),
            "player_handValue" => $handValue,
            "bank_hand" => $bankHand->getString(),
            "bank_handValue" => $bankHandValue,
            "turn" => $turn,
            "winner" => $winner
        ];

        return $this->render('game/gameboard.html.twig', $data);
    }


}
