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

class ClientRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param int $refuser
     * @param string $q
     * @return array
     */
    public function findAllClient(int $refuser, string $q) : array
    {
        $qb = $this->createQueryBuilder('cli');
        $qb
            ->select('cli')
            ->where('cli.userRef = :user')
            ->andWhere('cli.companyName LIKE :q OR cli.adress LIKE :q OR cli.zipcode LIKE :q OR cli.city LIKE :q')
            ->setParameter('user', $refuser)
            ->setParameter('q', '%'.$q.'%');
        return $qb->getQuery()->getResult();
    }
}
