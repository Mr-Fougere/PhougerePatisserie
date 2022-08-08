<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment/edit/{id}",name="edit_comment")
     */

    public function edit(Request $request, ManagerRegistry $doctrine, Comment $comment): Response
    {

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        $repository = $doctrine->getRepository(Comment::class);

        $comments = $repository->findBy(
            ['article' => $comment->getArticle()]
        );
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();
            return $this->redirect("/article/read/".$comment->getArticle()->getId());
        }
        return $this->render('article/read.html.twig', [
            'comments'=>$comments,
            'form' => $form->createView(),
            'article' => $comment->getArticle()
        ]);
    }
    /**
     * @Route("/comment/delete/{id}",name="delete_comment")
     */

    public function delete(ManagerRegistry $doctrine, Comment $comment): Response
    {
        $entityManager = $doctrine->getManager();

        $entityManager->remove($comment);
        $entityManager->flush();

        return $this->redirect("/article/read/" . $comment->getArticle()->getId());
    }

}
