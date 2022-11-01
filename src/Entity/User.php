<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getClients'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getClients'])]
    #[Assert\NotBlank(message: "Username est requis.")]
    #[Assert\Length(min: 4, max: 255, minMessage: " Username minimum {{ limit }} caractères", maxMessage: "Username maximum{{ limit }} caractères")]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getClients'])]
    #[Assert\NotBlank(message: "Email est requis.")]
    #[Assert\Email(message: "Votre email doit être valide.")]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['getClients'])]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
