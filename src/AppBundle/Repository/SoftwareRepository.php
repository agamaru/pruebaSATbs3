<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Empresa;
use AppBundle\Entity\TipoSoftware;
use Doctrine\ORM\EntityRepository;

class SoftwareRepository extends EntityRepository
{
    public function findByEmpresa(Empresa $empresa)
    {
        return $this->createQueryBuilder('s')
            ->where('s.empresa = :empresa')
            ->setParameter('empresa', $empresa)
            ->getQuery()
            ->getResult();
    }

    public function findByTipo(TipoSoftware $tipoSoftware)
    {
        return $this->createQueryBuilder('s')
            ->where('s.tipo = :tipo')
            ->setParameter('tipo', $tipoSoftware)
            ->getQuery()
            ->getResult();
    }

    public function findAllWithEmpresaAndTipoJoin()
    {
        return $this->createQueryBuilder('s')
            ->addSelect('e')
            ->addSelect('t')
            ->innerJoin('s.empresa', 'e')
            ->innerJoin('s.tipo', 't')
            ->getQuery()
            ->getResult();
    }
}