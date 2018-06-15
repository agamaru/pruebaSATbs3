<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Empresa;
use AppBundle\Entity\TipoSoftware;
use Doctrine\ORM\EntityRepository;

class SoftwareRepository extends EntityRepository
{
    public function findByQueryBuilder()
    {
        return $this->createQueryBuilder('s')
            ->addSelect('e')
            ->innerJoin('s.empresa', 'e');
    }

    public function findByEmpresa(Empresa $empresa)
    {
        return $this->createQueryBuilder('s')
            ->addSelect('t')
            ->innerJoin('s.tipo', 't')
            ->where('s.empresa = :empresa')
            ->setParameter('empresa', $empresa)
            ->getQuery()
            ->getResult();
    }

    public function findByTipo(TipoSoftware $tipoSoftware)
    {
        return $this->findByQueryBuilder()
            ->where('s.tipo = :tipo')
            ->setParameter('tipo', $tipoSoftware)
            ->getQuery()
            ->getResult();
    }

    public function findAllWithEmpresaAndTipoJoin()
    {
        return $this->findByQueryBuilder()
            ->addSelect('t')
            ->innerJoin('s.tipo', 't')
            ->getQuery()
            ->getResult();
    }
}