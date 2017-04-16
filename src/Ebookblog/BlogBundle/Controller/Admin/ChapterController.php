<?php

namespace Ebookblog\BlogBundle\Controller\Admin;

use Ebookblog\BlogBundle\Entity\Chapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ChapterController extends Controller
{
    /**
    * @Route("/admin/chapters/{state}", name="ebook_blog_chapters")
    */
    public function viewAction($state)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('EbookBlogBundle:Chapter');

        switch ($state) {

            case "all" :
                $listChapters = $repository->findAll();
                break;

            case "published" :
                $listChapters = $repository->findBy(
                    array('published' => 1)
                );
                break;

            case "unpublished" :

                $listChapters = $repository->findBy(
                    array('published' => 0)
                );
                break;

        };
        return $this->render('admin/chapters/view.html.twig', array(
            'listChapters' => $listChapters
            ));
    }

    /**
    * @Route("/admin/chapter/add", name="ebook_blog_chapter_add")
    */
    public function addAction(Request $request)
    {

        $session = $request->getSession();

        $session->getFlashBag()->add('info', 'Chapitre bien enregistré');

        // Le « flashBag » est ce qui contient les messages flash dans la session
        // Il peut bien sûr contenir plusieurs messages :
        $session->getFlashBag()->add('info', 'Oui oui, il est bien enregistré !');

        // Puis on redirige vers la page de visualisation de cette annonce
        return $this->redirectToRoute('ebook_blog_adminpage');
    }

    /**
    * @Route("/admin/chapter/{id}/edit", name="ebook_blog_chapter_edit", requirements={"id": "\d+"})
    */
    public function editAction($id, Request $request)
    {

        $session = $request->getSession();

        $session->getFlashBag()->add('info', 'Chapitre bien édité');

        return $this->redirectToRoute('ebook_blog_adminpage');
    }

    /**
    * @Route("/admin/chapter/{id}/delete", name="ebook_blog_chapter_delete", requirements={"id": "\d+"})
    */
    public function deleteAction($id, Request $request) {

        $session = $request->getSession();

        $session->getFlashBag()->add('info', 'Chapitre bien supprimé');

        return $this->redirectToRoute('ebook_blog_homepage');
    }



}
