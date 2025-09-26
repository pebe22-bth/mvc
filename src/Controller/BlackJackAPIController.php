<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Player;
use App\Entity\Highscore;
use App\Repository\HighscoreRepository;
use App\Repository\PlayerRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Card\BlackJack;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class BlackJackAPIController extends AbstractController
{
    #[Route("/api/blackjack/users", name: "api_blackjack_users", methods: ['GET'])]
    public function apiBlackjackUsers(
        PlayerRepository $playerRepository
    ): Response {

        $players = $playerRepository->findAllPlayers();
        $returnCode = "OK";
        $data = [
            "returnCode" => $returnCode,
            "players" => $players
            ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
    #[Route("/api/blackjack/start", name: "api_blackjack_start", methods: ['POST'])]
    public function apiBlackjackStart(
        Request $request,
        SessionInterface $session,
        PlayerRepository $playerRepository
    ): Response {

        $numberOfDecks = $request->request->get('numberOfDecks');
        $numberOfHands = $request->request->get('numberOfHands');
        $playerId = $request->request->get('playerId');

        if ($playerId) { // existing player
            $player = $playerRepository->find($playerId);
            $playerName = $player->getName();
    
            $game = new BlackJack();
            $game->startGame($numberOfDecks, $numberOfHands);
            $game->setPlayer($player->getId());
            $playerHand = $game->getPlayerHandsAsString();
            $playerValue = $game->getPlayerValue();
            $bankHand = $game->getBankHand();
            $bankValue = $game->getHandValue($bankHand);
            $winner = $game->getWinner();
            $turn = $game->getTurn();
            $currentHand = $game->getCurrentHand();
            $session->set("api_blackjack", $game);
            $returnCode = "OK";

            $data = [
            "returnCode" => $returnCode,
            "player" => $player->getName(),
            "player_hand" =>  $playerHand,
            "player_handValue" => $playerValue,
            "bank_hand" => $bankHand->getString(),
            "bank_handValue" => $bankValue,
            "winner" => $winner,
            "turn" => $turn,
            "current_hand" => $currentHand,
            "profit" => $game->getProfit()
            ];
        } else { 
            $returnCode = "Error: Id does not exist";
            $data = [
            "returnCode" => $returnCode
            ];
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
    #[Route("/api/blackjack/draw", name: "api_blackjack_draw")]
    public function apiBlackJackDraw(
        SessionInterface $session,
        PlayerRepository $playerRepository,
        ManagerRegistry $doctrine
    ): Response {
        $game = $session->get("api_blackjack");
        $player = null;
        if (($game->getPlayer()) && ($game->getTurn() !== "gameover") ){
            $player = $playerRepository->find($game->getPlayer());
            $playerName = $player->getName();;
        
            if ($game->getTurn() == "player") {
                $game->playerDraw();
            } elseif ($game->getTurn() == "bank") {
                $profit = $game->bankDraw();
            }
            $playerHand = $game->getPlayerHandsAsString();
            $playerValue = $game->getPlayerValue();
            $bankHand = $game->getBankHand();
            $bankValue = $game->getHandValue($bankHand);
            $winner = $game->getWinner();
            $turn = $game->getTurn();
            $profit = $game->getProfit();
            if ($turn === "gameover") {

                $coins = $player->getCoins() + $profit;
                $player->setCoins($coins);
                $highscore = $player->getHighscore();
                if (($player->getHighscore()->getCoins()) < $coins) {
                    $highscore->setCoins($coins);
                    $player->setHighscore($highscore);
                }
                $entityManager = $doctrine->getManager();
                $entityManager->persist($player);
                $entityManager->flush();
            }
            $currentHand = $game->getCurrentHand();

            $session->set("api_blackjack", $game);

            $returnCode = "OK";

            $data = [
            "returnCode" => $returnCode,
                "player" => $player->getName(),
                "player_id" => $player->getId(),
                "player_hand" =>  $playerHand,
                "player_handValue" => $playerValue,
                "bank_hand" => $bankHand->getString(),
                "bank_handValue" => $bankValue,
                "winner" => $winner,
                "turn" => $turn,
                "current_hand" => $currentHand,
                "profit" => $profit,
                "coins" => $player->getCoins(),
                "numberOfDecks" => $game->getNumberOfDecks(),
                "numberOfHands" => $game->getNumberOfHands()
            ];
        } else {
            $returnCode = "Error: Player does not exist, or game not started.";
            $data = [
            "returnCode" => $returnCode
            ];
        }
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
    #[Route("/api/blackjack/stop", name: "api_blackjack_stop")]
    public function apiBlackJackStop(
        SessionInterface $session,
        PlayerRepository $playerRepository,
        ManagerRegistry $doctrine
    ): Response {
        $game = $session->get("api_blackjack");
        if (($game instanceof BlackJack) && ( $game->getTurn() === "player" )) {

                $player = null;
                if ($game->getPlayer()) {
                    $player = $playerRepository->find($game->getPlayer());
                }
                $game->playerStop();
                $session->set("api_blackjack", $game);

                $playerHand = $game->getPlayerHandsAsString();
                $playerValue = $game->getPlayerValue();
                $bankHand = $game->getBankHand();
                $bankValue = $game->getHandValue($bankHand);
                $winner = $game->getWinner();
                $turn = $game->getTurn();
                $profit = $game->getProfit();
                $currentHand = $game->getCurrentHand();

                $returnCode = "OK";
                $data = [
                    "returnCode" => $returnCode,
                    "returnCode" => "OK",
                    "player" => $player->getName(),
                    "player_hand" =>  $playerHand,
                    "player_handValue" => $playerValue,
                    "bank_hand" => $bankHand->getString(),
                    "bank_handValue" => $bankValue,
                    "winner" => $winner,
                    "turn" => $turn,
                    "current_hand" => $currentHand,
                    "profit" => $profit,
                    "coins" => $player->getCoins()
                ];
        } else {
            $returnCode = "Error: Not Player turn, or no game started";
            $data = [
                "returnCode" => $returnCode
            ];
        }
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/blackjack/highscore", name: "api_blackjack_highscore")]
    public function apiBlackJackHighscore(
            HighscoreRepository $highscoreRepository
    ): Response {

        $highscores = $highscoreRepository->getHighscores();
        $returnCode = "OK";
        $data = [
           "returnCode" => $returnCode,
           "highscores" => $highscores
        ];
              
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;

    }
    #[Route("/api/blackjack/deck", name: "api_blackjack_deck")]
    public function apiBlackJackDeck(
        SessionInterface $session,
        PlayerRepository $playerRepository,
        ManagerRegistry $doctrine
    ): Response {
        $game = $session->get("api_blackjack");
        if ($game instanceof BlackJack) {
        $deck = $game->getDeck();

        $returnCode = "OK";
        $data = [
           "returnCode" => $returnCode,
           "deck" => $deck
        ];

        } else {
            $returnCode = "Error: Not Player turn, or no game started";
            $data = [
                "returnCode" => $returnCode
            ];
        }
              
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;

    }
}
