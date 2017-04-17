<?php

namespace Ebookblog\BlogBundle\Controller\Front;

use Ebookblog\BlogBundle\Entity\Chapter;
use Ebookblog\BlogBundle\Entity\Comment;
use Ebookblog\BlogBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ChapterController extends Controller {

    /**
    * @Route("/chapter/{id}", name="ebook_blog_view", requirements={"id": "\d+"})
    */
    public function viewAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();

        $chapter = $em
            ->getRepository('EbookBlogBundle:Chapter')
            ->find($id)
        ;

        if (null === $chapter) {
            throw new NotFoundHttpException("Le chapitre d'id ".$id." n'existe pas.");
        }

        $comments = $em
            ->getRepository('EbookBlogBundle:Comment')
            ->findBy(
            array('chapter' => $id, 'published' => 1)
        );

        $form = $this->get('form.factory')->create(CommentType::class);

        if ($request->isMethod('POST') && $form-> handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            $resquest->getSession()->getFlashbag()->add('info', 'Commentaire bien enregistré, en attente de modération');

            return $this->redirectToRoute('ebook_blog_view', array('id' => $id));
        }

        // Si on est pas en POST, alors on affiche le formulaire
        return $this->render('front/chapter/view.html.twig', array (
            'form' => $form->createView(),
            'chapter' => $chapter,
            'comments' => $comments,

        ));
    }

}
