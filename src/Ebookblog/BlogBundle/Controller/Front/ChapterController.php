<?php

/* View a particular chapter and associated comments + Comment form  */

namespace Ebookblog\BlogBundle\Controller\Front;

use Ebookblog\BlogBundle\Entity\Chapter;
use Ebookblog\BlogBundle\Entity\ChapterRepository;
use Ebookblog\BlogBundle\Entity\Comment;
use Ebookblog\BlogBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use ReCaptcha\ReCaptcha;

class ChapterController extends Controller {

    /**
    * @Route("/chapter/{id}", name="ebook_blog_view", requirements={"id": "\d+"})
    */
    public function viewAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();

        /* Chapter recuperation */
        $chapter = $em->getRepository('EbookBlogBundle:Chapter')->find($id);

        if (null === $chapter) {
            throw new NotFoundHttpException("Le chapitre d'id ".$id." n'existe pas.");
        }
        /* Comments on the chapter Recuperation*/
        $comments = $em->getRepository('EbookBlogBundle:Comment')->findBy(array('chapter' => $id, 'published' => 1), array('date' => 'DESC'));

        $comment = new Comment;

        /* Creation of the Comment form */
        $form = $this->get('form.factory')->create(CommentType::class, $comment);

        /* Test the validation of a user comment */
        if ($request->isMethod('POST') && $form-> handleRequest($request)->isValid()) {
            /* Verification by Google reCaptcha */
            $recaptcha = new ReCaptcha('6LckfyAUAAAAAEol6Et1tvBJmoaZ4a_nCxclg1cq');
            $resp = $recaptcha->verify($request->request->get('g-recaptcha-response'), $request->getClientIp());

            if (!$resp->isSuccess()) {
                // if the captcha submit wasn't valid : error message
                foreach ($resp->getErrorCodes() as $code) { $error = ''; $error .= $code ; }
                $message = "Le reCAPTCHA n'a pas fonctionné. Réessayez." . " (reCAPTCHA : " . $error . ")";
                $request->getSession()->getFlashbag()->add('info', $message);

            } else {
                /* Success of the Google reCaptcha validation */
                $em = $this->getDoctrine()->getManager();
                $comment->setChapter($chapter);
                $commentEmail = $comment->getEmail();
                /* Creation of the Gravatar url */
                $url = 'https://www.gravatar.com/avatar/';
                $url .= md5( strtolower( trim( $commentEmail ) ) );
                $url .= "?s=80&d=mm&r=g";
                $comment->setGravatar($url);
                /* Save the comment */
                $em->persist($comment);
                $em->flush();

                $request->getSession()->getFlashbag()->add('info', 'Commentaire bien enregistré, en attente de modération');
                return $this->redirectToRoute('ebook_blog_view', array('id' => $id));
            }
        }
        $dateCurrentChapter = $chapter->getDate();
        $prevChapter = $this->prevChapter($dateCurrentChapter);
        $nextChapter = $this->nextChapter($dateCurrentChapter);


        // If we're not in POST, we render the form
        return $this->render('front/chapter/view.html.twig', array (
            'form' => $form->createView(),
            'chapter' => $chapter,
            'comments' => $comments,
            'prevChapter' => $prevChapter,
            'nextChapter' => $nextChapter

        ));
    }

    public function prevChapter($dateCurrentChapter) {
        $qbPrev = $this
            ->getDoctrine()
            ->getRepository('EbookBlogBundle:Chapter')
            ->createQueryBuilder('c')
            ->where('c.date < :date')
            ->setParameter('date', $dateCurrentChapter)
            ->andWhere('c.published = ?1')
            ->setParameter(1, 1)
            ->orderBy('c.date', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
        return $qbPrev;

    }

    public function nextChapter($dateCurrentChapter) {
        $qbNext = $this
            ->getDoctrine()
            ->getRepository('EbookBlogBundle:Chapter')
            ->createQueryBuilder('c')
            ->where('c.date > :date')
            ->setParameter('date', $dateCurrentChapter)
            ->andWhere('c.published = ?1')
            ->setParameter(1, 1)
            ->orderBy('c.date', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
        return $qbNext;
    }

}
