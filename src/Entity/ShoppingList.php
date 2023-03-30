<?php

namespace App\Entity;

use App\Repository\ShoppingListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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

    public function __construct()
    {
        $this->articles = new ArrayCollection();
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
}
