<?php

/* Pages to administrate the chapters : published, unpublished, or both of them (view list, create, edit, delete) */

namespace Ebookblog\BlogBundle\Controller\Admin;

use Ebookblog\BlogBundle\Entity\Chapter;
use Ebookblog\BlogBundle\Form\ChapterType;
use Ebookblog\BlogBundle\Form\LegalMentionsType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class LegalMentionsController extends Controller
{
    /**
    * Edit Legal Mentions
    *
    * @Route("/admin/mentions-legales/edit", name="ebook_blog_admin_legalmentions_edit")
    */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $legalMentions = $em->getRepository('EbookBlogBundle:LegalMentions')->findOneById('1');

        $form = $this->get('form.factory')->create(LegalMentionsType::class, $legalMentions);

        if (null === $legalMentions) {
            throw new NotFoundHttpException("Les mentions légales n'existent pas");
        }


        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($legalMentions);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Mentions légales bien éditées');

            return $this->redirectToRoute('ebook_blog_admin_legalmentions_edit');

        }
        return $this->render('admin/legalmentions/edit.html.twig', array(
            'legalMentions' => $legalMentions,
            'form' => $form->createView()
        ));
    }

}
