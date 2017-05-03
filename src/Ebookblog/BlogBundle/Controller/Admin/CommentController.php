<?php

/* Moderation of the comments */

namespace Ebookblog\BlogBundle\Controller\Admin;

use Ebookblog\BlogBundle\Entity\Chapter;
use Ebookblog\BlogBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CommentController extends Controller
{
   /**
   * View comments, unpublished and waiting to be moderated, or all
   *
   * @Route("/admin/comments/{state}", name="ebook_blog_comments")
   * @Security("has_role('ROLE_ADMIN')")
   */

    public function viewListAction($state)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('EbookBlogBundle:Comment');

        if ($state == 'unpublished') {
            $listComments = $repository->findBy(
                array('published' => 0)
        );

        } else {
            $listComments = $repository->findAll();
        }

       return $this->render('admin/comments/viewList.html.twig', array(
           'listComments' => $listComments
       ));
    }

   /**
   * Read a specific comment
   *
   * @Route("/admin/comment/{id}", name="ebook_blog_comment", requirements={"id": "\d+"})
   * @Security("has_role('ROLE_ADMIN')")
   */

    public function viewAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $comment = $em->getRepository('EbookBlogBundle:Comment')->find($id);

        if (null === $comment) {
            throw new NotFoundHttpException("Le commentaire d'id ".$id." n'existe pas.");
        }

       return $this->render('admin/comments/view.html.twig', array(
           'comment' => $comment
       ));
    }

    /**
    * Moderate a comment : accept publication
    *
    * @Route("/admin/comments/{id}/accept", name="ebook_blog_comment_add", requirements={"id": "\d+"})
    */

    public function acceptAction($id, Request $request) {

        $em = $this->getDoctrine()->getManager();

        $comment = $em->getRepository('EbookBlogBundle:Comment')->find($id);

        if (null === $comment) {
            throw new NotFoundHttpException("Le commentaire d'id ".id. " n'existe pas.");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $comment->setPublished(true);
            $em->persist($comment);
            $em->flush();

              $request->getSession()->getFlashBag()->add('info', "Le commentaire a bien été publié.");

              return $this->redirectToRoute('ebook_blog_comments', array(
                  'state' =>'unpublished'
              ));
        }

        return $this->render('admin/comments/accept.html.twig', array(
          'comment' => $comment,
          'form'   => $form->createView(),
        ));
    }

    /**
    * Moderation : delete a comment
    *
    * @Route("/admin/comment/{id}/delete", name="ebook_blog_comment_delete", requirements={"id": "\d+"})
    */
    public function deleteAction($id, Request $request) {

        $em = $this->getDoctrine()->getManager();

        $comment = $em->getRepository('EbookBlogBundle:Comment')->find($id);

        if (null === $comment) {
            throw new NotFoundHttpException("Le commentaire d'id ".id. " n'existe pas.");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
          $em->remove($comment);
          $em->flush();

          $request->getSession()->getFlashBag()->add('info', "Le commentaire a bien été supprimé.");

          return $this->redirectToRoute('ebook_blog_comments', array(
              'state' =>'unpublished'
          ));
        }

        return $this->render('admin/comments/delete.html.twig', array(
          'comment' => $comment,
          'form'   => $form->createView(),
        ));
    }

}



