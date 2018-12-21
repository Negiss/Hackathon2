<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Theme;
use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index()
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/article-text", name="article-text")
     */
    public function article(ArticleRepository $article)
    {
        $themes = $this->getDoctrine()->getRepository(Theme::class)->findAll();
        $articles = $article->findAll();

        return $this->render('blog/articleText.html.twig', [
            'articles' => $articles,
            'themes' => $themes,
        ]);
    }

    /**
     * @Route("/article-video", name="article-video")
     */
    public function articleVideo()
    {
        return $this->render('blog/article-video.html.twig');
    }

    /**
     * @Route("/article-audio", name="article-audio")
     */
    public function articleAudio()
    {
        return $this->render('blog/article-audio.html.twig');
    }

    /**
     * @Route("/article-diapo", name="article-diapo")
     */
    public function articleDiapo()
    {
        return $this->render('blog/article-diapo.html.twig');
    }

    /**
     * @Route("/qui-sommes-nous", name="apropos")
     */
    public function apropos()
    {
        return $this->render('blog/apropos.html.twig');
    }

    /**
     * @Route("/article/{id}", name="article_id")
     */
    public function articleById(Article $article, Request $request): Response
    {
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findAll();

        $comment = new Comment();
        $form = $this->createFormBuilder($comment)
            ->add('message')
            ->add('save', SubmitType::class, array('label' => 'Send !'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $comment->setTimestamp(new \DateTime());
            $comment->setArticle($article);
            $em->persist($comment);
            $em->flush();
        }

        return $this->render('blog/articleById.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'comments' => $comments,
        ]);
    }
}
