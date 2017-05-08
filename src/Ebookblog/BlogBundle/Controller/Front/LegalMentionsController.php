<?php

/* View Legal Mentions  */

namespace Ebookblog\BlogBundle\Controller\Front;

use Ebookblog\BlogBundle\Entity\LegalMentions;
use Ebookblog\BlogBundle\Form\LegalMentionsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class LegalMentionsController extends Controller {

    /**
    * @Route("/mentions-legales", name="ebook_blog_legalmentions")
    */
    public function viewAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        /* LegalMentions recuperation */
        $legalMentions = $em->getRepository('EbookBlogBundle:LegalMentions')->findOneById('1');

        if (null === $legalMentions) {
            throw new NotFoundHttpException("Pas de mentions légales disponibles.");
        }

        return $this->render('front/legalmentions/view.html.twig', array (
            'legalMentions' => $legalMentions
        ));
    }

}
