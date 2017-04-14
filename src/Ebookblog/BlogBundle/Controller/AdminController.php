<?php

namespace Ebookblog\BlogBundle\Controller;

use Ebookblog\BlogBundle\Entity\Chapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction() {

        return $this->render('EbookBlogBundle:Admin:index.html.twig');
    }

    public function viewChaptersAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('EbookBlogBundle:Chapter');

        $listChapters = $repository->findAll();

       return $this->render('EbookBlogBundle:Admin:view-chapters.html.twig', array(
           'listChapters' => $listChapters
       ));
    }

    public function viewPublishedChaptersAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('EbookBlogBundle:Chapter');

        $listPublishedChapters = $repository->findBy(
            array('published' => 1)
        );

       return $this->render('EbookBlogBundle:Admin:view-chapters.html.twig', array(
           'listPublishedChapters' => $listPublishedChapters
       ));
    }

    public function viewUnpublishedChaptersAction()
    {
         $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('EbookBlogBundle:Chapter');

        $listUnpublishedChapters = $repository->findBy(
            array('published' => 0)
        );

       return $this->render('EbookBlogBundle:Admin:view-chapters.html.twig', array(
           'listUnpublishedChapters' => $listUnpublishedChapters
       ));
    }

    public function addChapterAction(Request $request)
    {

        $session = $request->getSession();

        $session->getFlashBag()->add('info', 'Chapitre bien enregistré');

        // Le « flashBag » est ce qui contient les messages flash dans la session
        // Il peut bien sûr contenir plusieurs messages :
        $session->getFlashBag()->add('info', 'Oui oui, il est bien enregistré !');

        // Puis on redirige vers la page de visualisation de cette annonce
        return $this->redirectToRoute('ebook_blog_adminpage');
    }

    public function editChapterAction($id, Request $request)
    {

        $session = $request->getSession();

        $session->getFlashBag()->add('info', 'Chapitre bien édité');

        return $this->redirectToRoute('ebook_blog_adminpage');
    }

    public function deleteChapterAction($id, Request $request) {

        $session = $request->getSession();

        $session->getFlashBag()->add('info', 'Chapitre bien supprimé');

        return $this->redirectToRoute('ebook_blog_homepage');
    }

    public function viewCommentsAction()
    {
         $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('EbookBlogBundle:Comment');

        $listComments = $repository->findAll();

       return $this->render('EbookBlogBundle:Admin:view-comments.html.twig', array(
           'listComments' => $listComments
       ));
    }

    public function viewUnpublishedCommentsAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('EbookBlogBundle:Comment');

        $listUnpublishedComments = $repository->findBy(
            array('published' => 0)
        );

       return $this->render('EbookBlogBundle:Admin:view-comments.html.twig', array(
           'listUnpublishedComments' => $listUnpublishedComments
       ));

    }

    public function acceptCommentAction($id, Request $request) {

        $session = $request->getSession();

        $session->getFlashBag()->add('info', 'Commentaire publié');

        return $this->redirectToRoute('ebook_blog_homepage');
    }

    public function deleteCommentAction($id, Request $request) {

        $session = $request->getSession();

        $session->getFlashBag()->add('info, Commentaire supprimé');

        return $this->redirectToRoute('ebook_blog_homepage');
    }



}
