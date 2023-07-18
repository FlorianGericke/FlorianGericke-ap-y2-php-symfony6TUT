<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/', methods:['get'])]
    final function index() : Response
    {
//        return new Response('
//            <html lang="en">
//                <body>
//                    <div>Hello</div>
//                </body>
//            </html>
//        ');
        return $this->render('articles/index.html.twig');
    }
}