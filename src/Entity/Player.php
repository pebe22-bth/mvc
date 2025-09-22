<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $coins = null;

    #[ORM\OneToOne(mappedBy: 'category', cascade: ['persist', 'remove'])]
    private ?Highscore $highscore = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCoins(): ?int
    {
        return $this->coins;
    }

    public function setCoins(int $coins): static
    {
        $this->coins = $coins;

        return $this;
    }

    public function getHighscore(): ?Highscore
    {
        return $this->highscore;
    }

    public function setHighscore(Highscore $highscore): static
    {
        
        if ($highscore->getCategory() !== $this) {
            $highscore->setCategory($this);
        }

        $this->highscore = $highscore;

        return $this;
    }


}
