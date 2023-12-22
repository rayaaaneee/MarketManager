<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JsonSerializable;

#[UniqueEntity(fields: ['Name', 'Surname'])]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Surname = null;

    #[ORM\Column(length: 255)]
    private ?string $Password = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ShoppingList::class, orphanRemoval: true)]
    private Collection $shoppingLists;

    #[ORM\OneToMany(mappedBy: 'receiver', targetEntity: CollaborationRequest::class, orphanRemoval: true)]
    private Collection $collaborationRequestsReceived;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Collaborator::class, orphanRemoval: true)]
    private Collection $collaborators;

    public function __construct()
    {
        $this->shoppingLists = new ArrayCollection();
        $this->collaborationRequestsReceived = new ArrayCollection();
        $this->collaborators = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->Surname;
    }

    public function setSurname(string $Surname): self
    {
        $this->Surname = $Surname;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): self
    {
        $this->Password = $Password;

        return $this;
    }

    /**
     * @return Collection<int, ShoppingList>
     */
    public function getShoppingLists(): Collection
    {
        return $this->shoppingLists;
    }

    public function addShoppingList(ShoppingList $shoppingList): self
    {
        if (!$this->shoppingLists->contains($shoppingList)) {
            $this->shoppingLists->add($shoppingList);
            $shoppingList->setUser($this);
        }

        return $this;
    }

    public function removeShoppingList(ShoppingList $shoppingList): self
    {
        if ($this->shoppingLists->removeElement($shoppingList)) {
            // set the owning side to null (unless already changed)
            if ($shoppingList->getUser() === $this) {
                $shoppingList->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CollaborationRequest>
     */
    public function getCollaborationRequestsReceived(): Collection
    {
        return $this->collaborationRequestsReceived;
    }

    public function addCollaborationRequestsReceived(CollaborationRequest $collaborationRequestsReceived): self
    {
        if (!$this->collaborationRequestsReceived->contains($collaborationRequestsReceived)) {
            $this->collaborationRequestsReceived->add($collaborationRequestsReceived);
            $collaborationRequestsReceived->setReceiver($this);
        }

        return $this;
    }

    public function removeCollaborationRequestsReceived(CollaborationRequest $collaborationRequestsReceived): self
    {
        if ($this->collaborationRequestsReceived->removeElement($collaborationRequestsReceived)) {
            // set the owning side to null (unless already changed)
            if ($collaborationRequestsReceived->getReceiver() === $this) {
                $collaborationRequestsReceived->setReceiver(null);
            }
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'surname' => $this->getSurname(),
            'password' => $this->getPassword(),
        ];
    }

    /**
     * @return Collection<int, Collaborator>
     */
    public function getCollaborators(): Collection
    {
        return $this->collaborators;
    }

    public function addCollaborator(Collaborator $collaborator): self
    {
        if (!$this->collaborators->contains($collaborator)) {
            $this->collaborators->add($collaborator);
            $collaborator->setUser($this);
        }

        return $this;
    }

    public function removeCollaborator(Collaborator $collaborator): self
    {
        if ($this->collaborators->removeElement($collaborator)) {
            // set the owning side to null (unless already changed)
            if ($collaborator->getUser() === $this) {
                $collaborator->setUser(null);
            }
        }

        return $this;
    }

    public function getAllShoppingLists(): array
    {
        $shoppingLists = $this->getShoppingLists()->toArray();
        foreach ($this->getCollaborators() as $collaborator) {
            $shoppingLists[] = $collaborator->getShoppingList();
        }
        return $shoppingLists;
    }
}
