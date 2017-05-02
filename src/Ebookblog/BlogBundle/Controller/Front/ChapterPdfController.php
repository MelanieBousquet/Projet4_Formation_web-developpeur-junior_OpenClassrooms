<?php

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
     * @Route(/chapter/{id}/pdf", name="ebook_blog_chapterpdf", requirements={"id": "\d+"})
     */
    public function chapterToPdfAction(Chapter $chapter)
    {
        $html = $this->renderView('front/chapter/chapterToPdf.html.twig', ['chapter' => $chapter,]);
        $htmltopdf = new \HTML2PDF('P', 'A4', 'fr', array(50, 50, 50, 50));
        $htmltopdf->pdf->SetDisplayMode('real');
        $htmltopdf->writeHTML($html);
        $htmltopdf->Output('Billet simple pour l\'Alaska, chapitre ' . $article->getId() . '.pdf');

        return new Response();
    }
}
