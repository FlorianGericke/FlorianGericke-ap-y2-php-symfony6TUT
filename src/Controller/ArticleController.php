<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
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
    final function add(Request $res, EntityManagerInterface $entityManager, LoggerInterface $logger): Response
    {
        $article = new Article();
        $form = $this->getForm($article, $res, 'Create');

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

    #[Route('/article/delete/{articleIdToDelete}', methods: ['DELETE'])]
    final function delete(EntityManagerInterface $entityManager, int $articleIdToDelete): void
    {
        $article = $entityManager->getRepository(Article::class)->find($articleIdToDelete);
        $entityManager->remove($article);
        $entityManager->flush();

        $res = new Response();
        $res->send();
    }

    /**
     * @param Article $article
     * @param Request $res
     * @return FormInterface
     */
    final function getForm(Article $article, Request $res, string $buttonCaption): FormInterface
    {
        $form = $this->createFormBuilder($article)
            ->add('Title', TextType::class,
                array('attr' =>
                    array('class' => 'form-control w-full', 'maxlength' => 50)))
            ->add('Body', TextareaType::class,
                array('attr' =>
                    array('class' => 'form-control w-full form-body-input'),
                ))
            ->add('Author', TextType::class,
                array('attr' =>
                    array('class' => 'form-control w-full', 'maxlength' => 50),
                ))
            ->add('Save', SubmitType::class,
                array('attr' =>
                    array('class' => 'btn-primary'),
                    'label' => $buttonCaption))
            ->getForm();

        $form->handleRequest($res);
        return $form;
    }
}