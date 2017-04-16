<?php

namespace Ebookblog\BlogBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class HomeController extends Controller
{
    /**
    * @Route("/admin", name="ebook_blog_adminpage")
    */
    public function indexAction() {

        return $this->render('admin/home/index.html.twig');
    }
}
