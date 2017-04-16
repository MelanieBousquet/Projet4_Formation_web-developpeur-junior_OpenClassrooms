<?php

namespace Ebookblog\BlogBundle\Controller\Admin;

use Ebookblog\BlogBundle\Entity\Chapter;
use Ebookblog\BlogBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class CommentController extends Controller
{
   /**
   * @Route("/admin/comments/{state}", name="ebook_blog_comments")
   */

    public function viewAction($state)
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

       return $this->render('admin/comments/view.html.twig', array(
           'listComments' => $listComments
       ));
    }
    /**
    * @Route("/admin/comments/{id}/accept", name="ebook_blog_comment_add", requirements={"id": "\d+"})
    */

    public function acceptAction($id, Request $request) {

        $session = $request->getSession();

        $session->getFlashBag()->add('info', 'Commentaire publié');

        return $this->redirectToRoute('ebook_blog_homepage');
    }

    /**
    * @Route("/admin/comment/{id}/delete", name="ebook_blog_comment_delete", requirements={"id": "\d+"})
    */
    public function deleteAction($id, Request $request) {

        $session = $request->getSession();

        $session->getFlashBag()->add('info, Commentaire supprimé');

        return $this->redirectToRoute('ebook_blog_homepage');
    }

}
