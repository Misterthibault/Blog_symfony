<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\EntityManager; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]         // route portant un nom, permet de l'appeler depuis n'importe où dans l'application plus facilement
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        return $this->render('article/index.html.twig', [
            'controller_name' => 'thibz',
            'articles' => $articles,
        ]);
    }

    #[Route('/commentaire', name: 'app_commentaire')]         // route portant un nom, permet de l'appeler depuis n'importe où dans l'application plus facilement
    public function afficherComment(CommentaireRepository $commentaireRepository): Response
    {
        $commentaire = $commentaireRepository->findAll();
        return $this->render('commentaire/index.html.twig', [
            // 'controller_name' => 'thibz',
            'commentaire' => $commentaire,
        ]);
    }

    #[Route('/article_show/{id}', name: 'article_show')]         // route portant un nom, permet de l'appeler depuis n'importe où dans l'application plus facilement
    public function show(article $article): Response
    {
        // $article = $articleRepository->find($id);
        return $this->render('article/article_show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/article2', name: 'app_article2')]     // route portant un nom, permet de l'appeler depuis n'importe où dans l'application plus facilement
    public function random(): Response
    {
        return $this->render('article/index2.html.twig', [
            'random_number' => rand(0, 100),
        ]);
    }

    #[Route('/addArticle', name: 'app_article_add')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        // Vérifie si le formulaire est envoyé ou non
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // récupère les données du formulaire
            $article = $form->getData();
            $article->setAuteur($this->getUser());
            $entityManager->persist($article); // on ajoute l'article dans l'entity manager pour qu'il puisse s'en occuper au moment du flush
            $entityManager->flush(); // on execute les req en BDD
            return $this->redirectToRoute('app_article');
        }

        return $this->render('article/add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/addCommentaire', name: 'app_commentaire_add')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function addCommentaire(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commentaire = new commentaire();

        $form = $this->createForm(commentaireType::class, $commentaire);

        // Vérifie si le formulaire est envoyé ou non
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // récupère les données du formulaire
            $commentaire->setAuteur($this->getUser());
            $entityManager->persist($commentaire); // on ajoute le commentaire dans l'entity manager pour qu'il puisse s'en occuper au moment du flush
            $entityManager->flush(); // on execute les req en BDD
            return $this->redirectToRoute('app_article');
        }

        return $this->render('article/add.html.twig', [
            'form' => $form,
        ]);
    }

    
}
