<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message="Le titre de votre article doit être renseigné")
     * @Assert\Length(max = 255)
     */
    private $titre;

    /**
     * @Gedmo\Slug(fields={"titre"}, updatable=true)
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(max = 255)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\OneToMany(targetEntity="ImageArticle", mappedBy="article", cascade={"persist", "remove"})
     */
    private $images;

    public function __construct() {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getTitre(): ?string {
        return $this->titre;
    }

    public function setTitre(string $titre): self {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(string $description): self {
        $this->description = $description;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getOneToMany(): ?string {
        return $this->OneToMany;
    }

    public function setOneToMany(string $OneToMany): self {
        $this->OneToMany = $OneToMany;

        return $this;
    }

    /**
     * @return Collection<int, ImageArticle>
     */
    public function getImages(): Collection {
        return $this->images;
    }

    public function addImage(ImageArticle $image): self {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setArticle($this);
        }

        return $this;
    }

    public function removeImage(ImageArticle $image): self {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getArticle() === $this) {
                $image->setArticle(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string {
        return $this->slug;
    }

    public function setSlug(string $slug): self {
        $this->slug = $slug;

        return $this;
    }

}
