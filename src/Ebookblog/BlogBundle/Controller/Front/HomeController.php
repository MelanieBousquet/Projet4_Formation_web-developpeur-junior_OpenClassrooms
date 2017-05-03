<?php

/* HomePage : List of chapters */

namespace Ebookblog\BlogBundle\Controller\Front;

use Ebookblog\BlogBundle\Entity\Chapter;
use Ebookblog\BlogBundle\Controller\Front\ChapterController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class HomeController extends Controller {

    /**
    * @Route("/", name="ebook_blog_homepage")
    */
    public function indexAction() {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('EbookBlogBundle:Chapter');

            $listChapters = $repository->findBy(
                    array('published' => 1)
            );

        return $this->render('front/home/index.html.twig', array(
            'listChapters' => $listChapters
        ));
    }

}
