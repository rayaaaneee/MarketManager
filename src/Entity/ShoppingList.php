<?php

namespace App\Entity;

use App\Repository\ShoppingListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Console\Helper\Dumper;

#[ORM\Entity(repositoryClass: ShoppingListRepository::class)]
class ShoppingList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    private ?int $nbArticles = null;

    #[ORM\ManyToOne(inversedBy: 'shoppingLists')]
    private ?User $user = null;

    #[ORM\Column(type: 'float', options: ['default' => 0])]
    private ?float $totalPrice = null;

    #[ORM\OneToMany(mappedBy: 'shoppingList', targetEntity: ArticleInList::class, orphanRemoval: true)]
    private Collection $articles;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\OneToMany(mappedBy: 'shoppingList', targetEntity: CollaborationRequest::class, orphanRemoval: true)]
    private Collection $collaborationRequests;

    #[ORM\OneToMany(mappedBy: 'shoppingList', targetEntity: Collaborator::class, orphanRemoval: true)]
    private Collection $collaborators;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->collaborationRequests = new ArrayCollection();
        $this->collaborators = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function hasDescription(): bool
    {
        return $this->description !== null;
    }

    public function getNbArticles(): ?int
    {
        return $this->nbArticles;
    }

    public function setNbArticles(int $nbArticles): self
    {
        $this->nbArticles = $nbArticles;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * @return Collection<int, ArticleInList>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(ArticleInList $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setShoppingList($this);
        }

        return $this;
    }

    public function removeArticle(ArticleInList $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getShoppingList() === $this) {
                $article->setShoppingList(null);
            }
        }

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function hasEndDate(): bool
    {
        return $this->endDate != null;
    }

    /**
     * @return Collection<int, CollaborationRequest>
     */
    public function getcollaborationRequests(): Collection
    {
        return $this->collaborationRequests;
    }

    public function addcollaborationRequests(CollaborationRequest $collaborationRequests): self
    {
        if (!$this->collaborationRequests->contains($collaborationRequests)) {
            $this->collaborationRequests->add($collaborationRequests);
            $collaborationRequests->setShoppingList($this);
        }

        return $this;
    }

    public function removecollaborationRequests(CollaborationRequest $collaborationRequests): self
    {
        if ($this->collaborationRequests->removeElement($collaborationRequests)) {
            // set the owning side to null (unless already changed)
            if ($collaborationRequests->getShoppingList() === $this) {
                $collaborationRequests->setShoppingList(null);
            }
        }

        return $this;
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
            $collaborator->setShoppingList($this);
        }

        return $this;
    }

    public function removeCollaborator(Collaborator $collaborator): self
    {
        if ($this->collaborators->removeElement($collaborator)) {
            // set the owning side to null (unless already changed)
            if ($collaborator->getShoppingList() === $this) {
                $collaborator->setShoppingList(null);
            }
        }

        return $this;
    }

    public function isCollaborator(User $user): bool
    {
        foreach ($this->collaborators as $collaborator) {
            if ($collaborator->getUser()->getId() === $user->getId()) {
                return true;
            }
        }
        return false;
    }
}
