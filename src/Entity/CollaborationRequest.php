<?php

namespace App\Entity;

use App\Repository\CollaborationRequestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CollaborationRequestRepository::class)]
class CollaborationRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'receiver')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ShoppingList $shoppingList = null;

    #[ORM\ManyToOne(inversedBy: 'collaborationRequestsReceived')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $receiver = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShoppingList(): ?ShoppingList
    {
        return $this->shoppingList;
    }

    public function setShoppingList(?ShoppingList $shoppingList): self
    {
        $this->shoppingList = $shoppingList;

        return $this;
    }

    public function getReceiver(): ?User
    {
        return $this->receiver;
    }

    public function setReceiver(?User $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }
}
