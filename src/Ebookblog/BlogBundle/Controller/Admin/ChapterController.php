<?php

/* Pages to administrate the chapters : published, unpublished, or both of them (view list, create, edit, delete) */

namespace Ebookblog\BlogBundle\Controller\Admin;

use Ebookblog\BlogBundle\Entity\Chapter;
use Ebookblog\BlogBundle\Form\ChapterType;
use Ebookblog\BlogBundle\Form\ChapterEditType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class ChapterController extends Controller
{
    /**
    * List of chapters (published or not, or both categories)
    *
    * @Route("/admin/chapters/{state}", name="ebook_blog_chapters")
    * @Security("has_role('ROLE_ADMIN')")
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
    * Add a chapter
    *
    * @Route("/admin/chapter/add", name="ebook_blog_chapter_add")
    */
    public function addAction(Request $request)
    {
        $chapter = new Chapter();
        $form = $this->get('form.factory')->create(ChapterType::class, $chapter);

        if ($request->isMethod('POST') && $form-> handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($chapter);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Chapitre bien enregistré');

            return $this->redirectToRoute('ebook_blog_chapters', array('state' => 'all'));

        }

        return $this->render('admin/chapters/add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
    * Edit a chapter
    *
    * @Route("/admin/chapter/{id}/edit", name="ebook_blog_chapter_edit", requirements={"id": "\d+"})
    */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $chapter = $em->getRepository('EbookBlogBundle:Chapter')->find($id);

        $form = $this->get('form.factory')->create(ChapterEditType::class, $chapter);

        if (null === $chapter) {
            throw new NotFoundHttpException("Le chapitre d'id ".id. " n'existe pas.");
        }

        if ($request->isMethod('POST') && $form-> handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($chapter);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Chapitre bien édité');

            return $this->redirectToRoute('ebook_blog_chapters', array('state' => 'all'));

        }
        return $this->render('admin/chapters/edit.html.twig', array(
            'chapter' => $chapter,
            'form' => $form->createView()
        ));
    }

    /**
    * Delete a chapter
    *
    * @Route("/admin/chapter/{id}/delete", name="ebook_blog_chapter_delete", requirements={"id": "\d+"})
    */
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $chapter = $em->getRepository('EbookBlogBundle:Chapter')->find($id);

        if (null === $chapter) {
            throw new NotFoundHttpException("Le chapitre d'id ".id. " n'existe pas.");
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
          $em->remove($chapter);
          $em->flush();

          $request->getSession()->getFlashBag()->add('info', "Le chapitre a bien été supprimé.");

          return $this->redirectToRoute('ebook_blog_chapters', array(
              'state' =>'all'
          ));
        }

        return $this->render('admin/chapters/delete.html.twig', array(
          'chapter' => $chapter,
          'form'   => $form->createView(),
        ));
    }

}
