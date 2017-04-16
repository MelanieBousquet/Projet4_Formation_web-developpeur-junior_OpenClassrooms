<?php

namespace Ebookblog\BlogBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class LoginController extends Controller {

    /**
     * @Route("/login", name="ebook_blog_login")
     */
    public function loginAction() {

        return $this->render('front/login/login.html.twig');
    }
}
