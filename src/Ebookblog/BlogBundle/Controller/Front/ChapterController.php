<?php

namespace Ebookblog\BlogBundle\Controller\Front;

use Ebookblog\BlogBundle\Entity\Chapter;
use Ebookblog\BlogBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ChapterController extends Controller {

    /**
    * @Route("/chapter/{id}", name="ebook_blog_view", requirements={"id": "\d+"})
    */
    public function viewAction($id) {

        // Si la requête est en POST, c'est que le visiteur a soumis le formulaire pour ajouter un commentaire
       /* if ($request->isMethod('POST')) {

            $resquest->getSession()->getFlashbag()->add('Info', 'Commentaire bien enregistré, en attente de modération');

            // On redirige vers la page de visualisation du chapitre et de ses commentaires
            return $this->redirectToRoute('ebook_blog_view', array('id' => $id));
        } */

        $em = $this->getDoctrine()->getManager();

        $chapter = $em
            ->getRepository('EbookBlogBundle:Chapter')
            ->find($id)
        ;

        if (null === $chapter) {
            throw new NotFoundHttpException("Le chapitre d'id ".$id." n'existe pas.");
        }

        $comments = $em
            ->getRepository('EbookBlogBundle:Comment')
            ->findBy(
            array('chapter' => $id, 'published' => 1)
        );

        // Si on est pas en POST, alors on affiche le formulaire
        return $this->render('front/chapter/view.html.twig', array (
            'chapter' => $chapter,
            'comments' => $comments
        ));
    }

}
