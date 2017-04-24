<?php

namespace Ebookblog\BlogBundle\Twig;


use Symfony\Bridge\Doctrine\RegistryInterface;


class ChaptersMenu extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    protected $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getGlobals ()
    {
        $repository = $this->doctrine
            ->getManager()
            ->getRepository('EbookBlogBundle:Chapter');

        $listChapters = $repository->findBy(
                    array('published' => 1)
            );

        return array(
            'listChapters' => $listChapters
        );

    }
}
