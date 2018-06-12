<?php

namespace AppBundle\Repository;


use AppBundle\Entity\TipoSoftware;
use Doctrine\ORM\EntityRepository;

class TipoSoftwareRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->createQueryBuilder('t')
            ->addOrderBy('t.nombre')
            ->getQuery()
            ->getResult();
    }

    public function delete(TipoSoftware $tipoSoftware)
    {
        $this->getEntityManager()
            ->createQuery('DELETE AppBundle:Software s WHERE s.tipo = :tipoSoftware')
            ->setParameter('tipoSoftware', $tipoSoftware)
            ->execute();
    }
}