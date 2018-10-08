<?php

/**
 *
 *  * This is an iumio component [https://iumio.com]
 *  *
 *  * (c) Mickael Buliard <mickael.buliard@iumio.com>
 *  *
 *  * Bill&Go, gérer votre administratif efficacement [https://www.billandgo.fr]
 *  *
 *  * To get more information about licence, please check the licence file
 *
 */

namespace BillAndGoBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ProjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectRepository extends EntityRepository
{

    /**
     * @param int $refuser
     * @param string $q
     * @return array
     */
    public function findAllProject(int $refuser, string $q) : array
    {
        $qb = $this->createQueryBuilder('proj');
        $qb
            ->select('proj')
            ->where('proj.refUser = :user')
            ->andWhere('proj.description LIKE :q OR proj.name LIKE :q')
            ->setParameter('user', $refuser)
            ->setParameter('q', '%'.$q.'%');
        return $qb->getQuery()->getResult();
    }

}
