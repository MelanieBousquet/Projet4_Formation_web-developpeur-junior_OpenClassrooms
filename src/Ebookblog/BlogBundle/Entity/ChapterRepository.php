<?php

namespace Ebookblog\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ChapterRepository extends EntityRepository
{
    public function findPrevChapter($dateCurrentChapter) {
$repository = $this->getDoctrine()
    ->getRepository('EbookBlogBundleBundle:Chapter');
        $qb = $repository->createQueryBuilder('c');

        $qb->where('c.date < :date')
            ->setParameter('date', $dateCurrentChapter)
            ->orderBy('c.date', 'DESC')
            ->setMaxResults(1)
        ;

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
}
