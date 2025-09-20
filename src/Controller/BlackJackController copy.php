<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Player;
use App\Entity\Highscore;
use Doctrine\Persistence\ManagerRegistry;
use App\Card\BlackJack;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BlackJackController extends AbstractController
{
    #[Route("/proj", name: "blackjack_home")]
    public function game(): Response
    {
        return $this->render('blackjack/home.html.twig');
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
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();
        $playerName = $request->request->get('playerName');
        $player = new Player();
        $player->setName($playerName);
        $player->setCoins(10);
        $highscore = new Highscore();
        $highscore->setCoins(10);
        $player->setHighscore($highscore);
        
        $entityManager->persist($player);
        $entityManager->flush();
        
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
        }

        if ($game instanceof BlackJack === false) {
            throw new Exception("BlackJack game not found in session, starting a new game.");
        }
        if ($game->getTurn() == "player"){
            $game->playerDraw();
        }
        else {
            $profit = $game->bankDraw();
        }
        
        $playerHand = $game->getPlayerHandsAsString();
        $playerValue = $game->getPlayerValue();
        $bankHand = $game->getBankHand();
        $bankValue = $game->getHandValue($bankHand);
        $winner = $game->getWinner();
        $turn = $game->getTurn();
        $currentHand = $game->getCurrentHand();

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
        
        $playerHand = $game->getPlayerHandsAsString();
        $playerValue = $game->getPlayerValue();
        $bankHand = $game->getBankHand();
        $bankValue = $game->getHandValue($bankHand);
        $winner = $game->getWinner();
        $turn = $game->getTurn();
        $currentHand = $game->getCurrentHand();

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
    #[Route("/blackjack/deck", name: "blackjack_deck")]
    public function blackJackDeck(
        SessionInterface $session
    ): Response {
        $game = $session->get("blackjack");
        
        $data = [
            "deck" => $game->getDeck()
        ];

        return $this->render('blackjack/deck.html.twig', $data);
    }
    


}
