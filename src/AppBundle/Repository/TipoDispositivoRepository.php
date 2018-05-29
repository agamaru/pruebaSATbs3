<?php
/**
 * Created by PhpStorm.
 * User: elsiore
 * Date: 22/05/18
 * Time: 18:49
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class TipoDispositivoRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->createQueryBuilder('t')
            ->addOrderBy('t.nombre')
            ->getQuery()
            ->getResult();
    }
}