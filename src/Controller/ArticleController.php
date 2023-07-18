<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/', methods: ['get'])]
    final function index(): Response
    {
        $articles = [
            'Article1',
            'Article2',
            'Article3'
        ];

        return $this->render('articles/index.html.twig', array(
            'articles' => $articles,
        ));
    }
}