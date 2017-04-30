<?php

/* Extension Twig : Dynamic Menu of the publicated Chapters, for all 'Front' Views */

namespace Ebookblog\BlogBundle\Twig;

use Twig_Environment as Environment;
use Symfony\Bridge\Doctrine\RegistryInterface;


class ChaptersMenu extends \Twig_Extension
{
    protected $doctrine;
    protected $twig;

    public function __construct(RegistryInterface $doctrine, Environment $twig)
    {
        $this->doctrine = $doctrine;
        $this->twig = $twig;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getChapters', array($this, 'getChapters'))
        );

    }

    public function getChapters()
    {
        $repository = $this->doctrine
            ->getManager()
            ->getRepository('EbookBlogBundle:Chapter');

        $listChapters = $repository->findBy(
                    array('published' => 1)
            );

         return $this->twig->render('front/menu.html.twig', array (
            'listChapters' => $listChapters

        ));
    }

    public function getName()
    {
        return 'ChaptersMenu';
    }
}
