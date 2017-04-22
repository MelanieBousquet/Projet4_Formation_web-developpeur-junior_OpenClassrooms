<?php

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

        return $this->render('admin/home/index.html.twig');
    }
}
