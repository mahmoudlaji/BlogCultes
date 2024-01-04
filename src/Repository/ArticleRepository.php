<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Article::class);
    }

    public function getBlogC($titre, $description, $slug) {
        $qb = $this->createQueryBuilder("ar");

        if ($titre) {
            $qb->andWhere("ar.titre LIKE :titre")->setParameter("titre", '%' . trim($titre) . '%');
        }

        if ($description) {
            $qb->andWhere("ar.description LIKE :description")->setParameter("description", '%' . trim($description) . '%');
        }

        if ($slug) {
            $qb->andWhere("ar.slug = :slug")->setParameter("slug", trim($slug));
        }



        return $qb;
    }

}
