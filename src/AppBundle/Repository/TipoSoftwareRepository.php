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
        $softwares = $this->getEntityManager()
            ->getRepository('AppBundle:Software')
            ->findByTipo($tipoSoftware);

        foreach($softwares as $software) {
            $this->getEntityManager()->remove($software);
        }

        $this->getEntityManager()->remove($tipoSoftware);
    }
}