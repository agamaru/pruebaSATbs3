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
        $dispositivos = $this->getEntityManager()
            ->getRepository('AppBundle:DispositivoRed')
            ->findByTipo($tipoDispositivo);

        foreach($dispositivos as $dispositivo) {
            $this->getEntityManager()->remove($dispositivo);
        }

        $this->getEntityManager()->remove($tipoDispositivo);
    }
}