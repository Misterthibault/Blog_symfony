<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contenue = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $date = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    private ?Categorie $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $auteur = null;

    /**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'article_id')]
    private Collection $user_id;

    public function __construct()
    {
        $this->date_creation = new \DateTime();
        $this->user_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenue(): ?string
    {
        return $this->contenue;
    }

    public function setContenue(?string $contenue): static
    {
        $this->contenue = $contenue;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(?\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getAuteur(): ?User
    {
        return $this->auteur;
    }

    public function setAuteur(?User $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getUserId(): Collection
    {
        return $this->user_id;
    }

    public function addUserId(Commentaire $userId): static
    {
        if (!$this->user_id->contains($userId)) {
            $this->user_id->add($userId);
            $userId->setArticleId($this);
        }

        return $this;
    }

    public function removeUserId(Commentaire $userId): static
    {
        if ($this->user_id->removeElement($userId)) {
            // set the owning side to null (unless already changed)
            if ($userId->getArticleId() === $this) {
                $userId->setArticleId(null);
            }
        }

        return $this;
    }
}
