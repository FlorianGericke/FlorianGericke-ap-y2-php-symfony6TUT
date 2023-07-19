<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


#[ORM\Entity]
#[ORM\Table(name: 'article_controller')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'article_list', methods: ['get'])]
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

    #[Route('/article/add', methods: ['GET', 'POST'])]
    final function addArticle(Request $res, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createFormBuilder($article)
            ->add('Title', TextType::class, array('attr' =>
                array('class' => 'form-control')))
            ->add('Body', TextareaType::class, array('attr' =>
                array('class' => 'form-control'),
                'required' => false))
            ->add('Quality', TextareaType::class, array('attr' =>
                array('class' => 'form-control'),
                'required' => false))
            ->add('Save', SubmitType::class, array('attr' =>
                array('class' => 'btn-primary'),
                'label' => 'Create'))
            ->getForm();

        $form->handleRequest($res);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_list');
        }

        return $this->render('articles/new.html.twig', array(
            'form' => $form->createView()
        ));
    }
}