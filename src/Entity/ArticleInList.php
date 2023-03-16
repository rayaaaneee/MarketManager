<?php

namespace App\Entity;

use App\Repository\ArticleInListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleInListRepository::class)]
class ArticleInList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?float $totalPrice = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ShoppingList $idShoppingList = null;

    #[ORM\OneToMany(mappedBy: 'articleInList', targetEntity: Article::class)]
    private Collection $idArticle;

    #[ORM\Column]
    private ?float $unityPrice = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $brand = null;

    public function __construct()
    {
        $this->idArticle = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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

    public function getIdShoppingList(): ?ShoppingList
    {
        return $this->idShoppingList;
    }

    public function setIdShoppingList(?ShoppingList $idShoppingList): self
    {
        $this->idShoppingList = $idShoppingList;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getIdArticle(): Collection
    {
        return $this->idArticle;
    }

    public function addIdArticle(Article $idArticle): self
    {
        if (!$this->idArticle->contains($idArticle)) {
            $this->idArticle->add($idArticle);
            $idArticle->setArticleInList($this);
        }

        return $this;
    }

    public function removeIdArticle(Article $idArticle): self
    {
        if ($this->idArticle->removeElement($idArticle)) {
            // set the owning side to null (unless already changed)
            if ($idArticle->getArticleInList() === $this) {
                $idArticle->setArticleInList(null);
            }
        }

        return $this;
    }

    public function getUnityPrice(): ?float
    {
        return $this->unityPrice;
    }

    public function setUnityPrice(float $unityPrice): self
    {
        $this->unityPrice = $unityPrice;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }
}
