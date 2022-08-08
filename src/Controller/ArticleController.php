<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use ColorThief\ColorThief;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article/create", name="article_create")
     */
    public function createArticle(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        $newArticle =  new Article();

        $form = $this->createForm(ArticleType::class, $newArticle);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $brochureFile = $form->get('brochureFileName')->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                   
                }
                $newArticle->setBrochureFilename($newFilename);
            }
            if(!$form->get('price')->getData()){
                $newArticle->setPrice("€");
            }
            $newArticle->setMainColor(json_encode([rand(0,255),rand(0,255),rand(0,255,)]));
            $newArticle->setCreatedAt(new DateTime());
            $entityManager->persist($newArticle);
            $entityManager->flush();

            return $this->redirectToRoute("read_all_article");
        }

        return $this->render('article/new.html.twig', [
            "form" => $form->createView(),
            'typeForm'=>"Publier la recette",
        ]);
    }

    /**
     * @Route("/article/edit/{id}",name="edit_article")
     */

    public function edit(Request $request, ManagerRegistry $doctrine, Article $article, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $brochureFile = $form->get('brochureFileName')->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                   
                }
                $article->setBrochureFilename($newFilename);
            }
            $doctrine->getManager()->flush();
            return $this->redirectToRoute("read_all_article");
        }

        return $this->render('article/new.html.twig', [
            "form" => $form->createView(),
            "typeForm"=>"Editer la recette"
         ]);
    }
    /**
     * @Route("/article/delete/{id}",name="delete_article")
     */

    public function delete(ManagerRegistry $doctrine, Article $article): Response
    {
        $entityManager = $doctrine->getManager();

        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute("read_all_article");
    }

    /**
     * @Route("/article/read-all",name="read_all_article")
     */
    public function readAll(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Article::class);

        $articles = $repository->findAll();

        return $this->render('article/read_all.html.twig', [
            "articles" => $articles
        ]);
    }
    /**
     * @Route("/article/read/{id}",name="read_article")
     */
    public function read(ManagerRegistry $doctrine, Article $article,Request $request): Response
    {
        $newComment =  new Comment();

        $form = $this->createForm(CommentType::class, $newComment);

        $form->handleRequest($request);
        $repository = $doctrine->getRepository(Comment::class);

        $comments = $repository->findBy(
            ['article' => $article]
        );
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $newComment->setDate(new DateTime());
            $newComment->setArticle($article);
            $entityManager->persist($newComment);
            $entityManager->flush();
            return $this->redirect("/article/read/".$article->getId());
        }
        return $this->render('article/read.html.twig', [
            'comments'=>$comments,
            'form' => $form->createView(),
            'article' => $article
        ]);
    }
}
