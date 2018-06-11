<?php

namespace AppBundle\Repository;


use AppBundle\Entity\TipoDispositivo;
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

    public function delete(TipoDispositivo $tipoDispositivo)
    {
        $this->getEntityManager()
            ->createQuery('DELETE AppBundle:DispositivoRed d WHERE d.tipo = :tipoDispositivo')
            ->setParameter('tipoDispositivo', $tipoDispositivo)
            ->execute();
    }
}