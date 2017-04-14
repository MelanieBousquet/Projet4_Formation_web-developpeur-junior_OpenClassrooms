<?php

namespace Ebookblog\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class FrontController extends Controller {

    public function indexAction() {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('EbookBlogBundle:Chapter');

        $listChapters = $repository->findAll();

        return $this->render('EbookBlogBundle:Front:index.html.twig', array(
            'listChapters' => $listChapters
        ));
    }

    public function viewAction($id) {

        // Si la requête est en POST, c'est que le visiteur a soumis le formulaire pour ajouter un commentaire
       /* if ($request->isMethod('POST')) {

            $resquest->getSession()->getFlashbag()->add('Info', 'Commentaire bien enregistré, en attente de modération');

            // On redirige vers la page de visualisation du chapitre et de ses commentaires
            return $this->redirectToRoute('ebook_blog_view', array('id' => $id));
        } */

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('EbookBlogBundle:Chapter');

        $chapter = $repository->find($id);

        // Si on est pas en POST, alors on affiche le formulaire
        return $this->render('EbookBlogBundle:Front:view.html.twig', array (
            'chapter' => $chapter,
        ));
    }

    public function loginAction() {

        return $this->render('EbookBlogBundle:Front:login.html.twig');
    }
}
