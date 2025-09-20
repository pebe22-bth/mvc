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
use Psr\Log\LoggerInterface;

class BlackJackController extends AbstractController
{
    #[Route("/proj", name: "blackjack_home")]
    public function game(): Response
    {
        return $this->redirectToRoute('blackjack_start');
    }
    #[Route("/proj/about", name: "blackjack_about")]
    public function doc(): Response
    {

        return $this->render('blackjack/about.html.twig');
    }
    #[Route("/proj/start", name: "blackjack_start", methods: ['GET'])]
    public function blackJackInit(
        ManagerRegistry $doctrine
    ): Response {
        $players = [];
        $players = $doctrine->getRepository(Player::class)->findAll();

        $data = [
            "players" => $players
        ];

        return $this->render('blackjack/home.html.twig', $data);
    }
    #[Route("/proj/start", name: "blackjack_start_post", methods: ['POST'])]
    public function blackJackStart(
        Request $request,
        SessionInterface $session,
        ManagerRegistry $doctrine,
        PlayerRepository $playerRepository
        //    LoggerInterface $logger
    ): Response {

        $entityManager = $doctrine->getManager();

        $playerId = $request->request->get('playerId');
        if ($playerId) { // existing player
            $player = $doctrine->getRepository(Player::class)->find($playerId);
            $playerName = $player->getName();
        } else { // New player
            $playerName = $request->request->get('playerName');
            $player = $playerRepository->findName($playerName);
            if ($player !== null) {
                throw new Exception("Player name already exists.");
            }
            $player = new Player();
            $player->setName($playerName);
            $player->setCoins(10);
            $highscore = new Highscore();
            $highscore->setCoins(10);
            $player->setHighscore($highscore);
            $entityManager->persist($player);
            $entityManager->flush();

        }

        $numberOfDecks = $request->request->get('numberOfDecks');
        $numberOfHands = $request->request->get('numberOfHands');

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
        $this->addFlash(
            'notice',
            'Black Jack restarted!'
        );
        $session->set("blackjack", $game);

        $data = [
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

        return $this->render('blackjack/gameboard.html.twig', $data);
    }

    #[Route("/proj/draw", name: "blackjack_draw")]
    public function blackJackDraw(
        SessionInterface $session,
        ManagerRegistry $doctrine
    ): Response {
        $game = $session->get("blackjack");
        $player = null;
        if ($game->getPlayer()) {
            $player = $doctrine->getRepository(Player::class)->find($game->getPlayer());
        } else {
            throw new Exception("Player in session doesn't exist in the database, or database problem.");
        }

        if ($game instanceof BlackJack === false) {
            throw new Exception("BlackJack game not found in session, starting a new game.");
        }
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

        $session->set("blackjack", $game);

        $data = [
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
        return $this->render('blackjack/gameboard.html.twig', $data);
    }

    #[Route("/blackjack/player_stop", name: "blackjack_player_stop")]
    public function blackJackPlayerStop(
        SessionInterface $session,
        ManagerRegistry $doctrine
    ): Response {
        $game = $session->get("blackjack");
        if (($game instanceof BlackJack) === false) {
            throw new Exception("Black Jack game not found in session, starting a new game.");
        }
        $player = null;
        if ($game->getPlayer()) {
            $player = $doctrine->getRepository(Player::class)->find($game->getPlayer());
        }
        $game->playerStop();
        $session->set("blackjack", $game);

        $playerHand = $game->getPlayerHandsAsString();
        $playerValue = $game->getPlayerValue();
        $bankHand = $game->getBankHand();
        $bankValue = $game->getHandValue($bankHand);
        $winner = $game->getWinner();
        $turn = $game->getTurn();
        $profit = $game->getProfit();
        $currentHand = $game->getCurrentHand();


        $data = [
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
        return $this->render('blackjack/gameboard.html.twig', $data);
    }

    #[Route("/proj/highscore", name: "blackjack_highscore", methods: ['GET'])]
    public function blackJackHighscore(
        HighscoreRepository $highscoreRepository
        //    LoggerInterface $logger
    ): Response {

        $highscores = $highscoreRepository->getHighscores();
        $data = [
           "highscores" => $highscores
        ];

        return $this->render('blackjack/scoreboard.html.twig', $data);
    }
    #[Route("/proj/about/database", name: "blackjack_database", methods: ['GET'])]
    public function blackJackDatabase(
    ): Response {

        return $this->render('blackjack/database.html.twig');
    }


}
