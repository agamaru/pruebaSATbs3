<?php

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