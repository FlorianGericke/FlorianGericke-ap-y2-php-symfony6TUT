<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[ORM\Entity]
#[ORM\Table(name: 'article_controller')]
class ArticleController extends AbstractController
{
    #[Route('/', methods: ['get'])]
    final function index(EntityManagerInterface $entityManager): Response
    {
        $articles = $entityManager->getRepository(Article::class)->findAll();

        return $this->render('articles/index.html.twig', array(
            'articles' => $articles,
        ));
    }

    // Don't use get to add data to the database. This gets changed to Post later in the tutorial
    #[Route('/article/save', methods: ['get'])]
    final function save(EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $article->setTitle('Article One');
        $article->setBody('Body1');
        $article->setQuality('poor');

        $entityManager->persist($article);
        $entityManager->flush();

        return new Response('Saved new product with id '.$article->getId());
    }

}