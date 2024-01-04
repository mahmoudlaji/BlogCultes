<?php

namespace App\Entity;

use App\Repository\ImageArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageArticleRepository::class)
 */
class ImageArticle {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="images")
     */
    private $article;

    public function getId(): ?int {
        return $this->id;
    }

    public function getArticle(): ?Article {
        return $this->article;
    }

    public function setArticle(?Article $article): self {
        $this->article = $article;

        return $this;
    }

    public function getArticleb(): ?Article {
        return $this->articleb;
    }

    public function setArticleb(?Article $articleb): self {
        $this->articleb = $articleb;

        return $this;
    }

}
