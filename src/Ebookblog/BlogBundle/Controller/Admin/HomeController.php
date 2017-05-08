<?php

/* Admin HomePage : number and list of unpublished chapters, number and list of unmoderated comments  */

namespace Ebookblog\BlogBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class HomeController extends Controller
{
    /**
    * @Route("/admin", name="ebook_blog_adminpage")
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function indexAction() {
        $repository = $this
            ->getDoctrine()
            ->getManager();

        $listChapters = $repository
            ->getRepository('EbookBlogBundle:Chapter')
            ->findBy(
                array('published' => 0), array('date' => 'DESC')
            );
        $nbChapters = (int)count($listChapters);

        $listComments = $repository
            ->getRepository('EbookBlogBundle:Comment')
            ->findBy(
                array('published' => 0), array('date' => 'DESC')
        );
        $nbComments = (int)count($listComments);

        return $this->render('admin/home/index.html.twig', array(
            'listChapters' => $listChapters,
            'nbChapters' => $nbChapters,
            'listComments' => $listComments,
            'nbComments' => $nbComments

        ));
    }
}
