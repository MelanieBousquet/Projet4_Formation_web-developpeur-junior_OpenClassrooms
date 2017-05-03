<?php

/* Convert a chapter view in PDF, in order to read a chapter in PDF format */

namespace Ebookblog\BlogBundle\Controller\Front;

use Ebookblog\BlogBundle\Entity\Chapter;
use Ebookblog\BlogBundle\Entity\Comment;
use Ebookblog\BlogBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ChapterPdfController extends Controller {

     /**
     * Generate Chapter in PDF version
     *
     * @Route("/chapter/{id}/pdf", name="ebook_blog_chapterpdf", requirements={"id": "\d+"})
     */
    public function chapterToPdfAction(Chapter $chapter)
    {
        /* the view we need to convert in pdf */
        $html = $this->renderView('front/chapter/chapterToPdf.html.twig', array('chapter' => $chapter));
        /* call of the html2pdf service */
        $htmltopdf = $this->get('html2pdf_factory')->create('P', 'A4', 'fr', array(100, 100, 100, 100));
        /* real size */
        $htmltopdf->pdf->SetDisplayMode('real');
        /* Take the view in order to convert it in pdf */
        $htmltopdf->writeHTML($html);
        /* Send PDF doc to the pae*/
        $htmltopdf->Output('Billet simple pour l\'Alaska, chapitre ' . $chapter->getId() . '.pdf');

        return new Response();
    }

}
