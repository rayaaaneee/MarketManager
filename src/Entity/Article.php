<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use App\Repository\TypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article extends TypeRepository
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column]
    private ?int $Stock = null;

    #[ORM\Column]
    private ?float $UnityPrice = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $type = null;

    #[ORM\ManyToOne(inversedBy: 'idArticle')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ArticleInList $articleInList = null;

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

    public function getStock(): ?int
    {
        return $this->Stock;
    }

    public function setStock(int $Stock): self
    {
        $this->Stock = $Stock;

        return $this;
    }

    public function getUnityPrice(): ?float
    {
        return $this->UnityPrice;
    }

    public function setUnityPrice(float $UnityPrice): self
    {
        $this->UnityPrice = $UnityPrice;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getArticleInList(): ?ArticleInList
    {
        return $this->articleInList;
    }

    public function setArticleInList(?ArticleInList $articleInList): self
    {
        $this->articleInList = $articleInList;

        return $this;
    }
}
