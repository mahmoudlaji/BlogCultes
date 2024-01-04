<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\ImageArticle;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ArticleType;
use Knp\Component\Pager\PaginatorInterface;

class BlogCController extends AbstractController {

    /**
     * @Route("/", name="page_accueil")
     */
    public function accueil(ManagerRegistry $doctrine, PaginatorInterface $paginator, Request $request): Response {


        $articlesqb = $doctrine->getRepository(Article::class)->getBlogC(null, null, null);

        $articleQuery = $articlesqb->getQuery();

        $articles = $paginator->paginate(
                $articleQuery, /* query NOT result */
                $request->query->getInt('page', 1), /* page number */
                2 /* limit per page */
        );
        return $this->render('accueil.html.twig', ["articles" => $articles]);
    }

    /**
     * @Route("/articles/{slug}", name="page_details")
     */
    public function details($slug, ManagerRegistry $doctrine): Response {

        $article = $doctrine->getRepository(Article::class)->findOneBy(["slug" => $slug]);

        if (!$article) {

            $this->addFlash('warning', "Votre article non trouvée");
            return $this->redirectToRoute('page_accueil');
        }

        return $this->render('details.html.twig', ["article" => $article]);
    }

    /**
     * @Route("/articles/modifier/{slug}", name="page_modifier")
     */
    public function modifier($slug, ManagerRegistry $doctrine, Request $request): Response {

        $article = $doctrine->getRepository(Article::class)->findOneBy(["slug" => $slug]);

        if (!$article) {
            $this->addFlash('warning', "Votre article non trouvée");
            return $this->redirectToRoute('page_accueil');
        }
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $doctrine->getManager();
                $article->setDateCreation(new \DateTime);
                $em->persist($article);
                $em->flush();
                $this->addFlash('success', "Votre article a été bien modifier");
                return $this->redirectToRoute('page_accueil');
            }
        }

        return $this->render('modifier.html.twig', [
                    "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/articles/supp/{slug}", name="page_supp")
     */
    public function supp($slug, ManagerRegistry $doctrine, Request $request): Response {

        $article = $doctrine->getRepository(Article::class)->findOneBy(["slug" => $slug]);

        if (!$article) {
            $this->addFlash('warning', "Votre article non trouvée");
            return $this->redirectToRoute('page_accueil');
        }
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        $em = $doctrine->getManager();
        $em->remove($article);
        $em->flush();
        $this->addFlash('success', "Votre article a été bien supprimer");
        return $this->redirectToRoute('page_accueil');
    }

    /**
     * @Route("/addArticles", name="page_addArticles")
     */
    public function addArticles(ManagerRegistry $doctrine, Request $request): Response {


        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $doctrine->getManager();
                $article->setDateCreation(new \DateTime);
                $em->persist($article);
                $em->flush();
                $this->addFlash('success', "Votre article a été bien ajoutée");
                return $this->redirectToRoute('page_accueil');
            }
        }

        return $this->render('addArticles.html.twig', [
                    "form" => $form->createView(),
        ]);
    }

}
