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

    #[Route('/article/num/{id}', methods: ['get'])]
    final function show(EntityManagerInterface $entityManager, string $id): Response
    {
        $article = $entityManager->getRepository(Article::class)->find($id);

        return $this->render('articles/show.html.twig', array(
            'article' => $article,
        ));
    }

    #[Route('/article/save', methods: ['get'])]
    final function save(EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $article->setTitle('Article One');
        $article->setBody('Body1');
        $article->setQuality('poor');

        $entityManager->persist($article);
        $entityManager->flush();

        return $this->render('articles/show.html.twig', array(
            'article' => $article,
        ));
    }

}