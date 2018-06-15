<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Empresa;
use AppBundle\Entity\TipoDispositivo;
use Doctrine\ORM\EntityRepository;

class DispositivoRedRepository extends EntityRepository
{
    public function findByEmpresa(Empresa $empresa)
    {
        return $this->createQueryBuilder('d')
            ->where('d.empresa = :empresa')
            ->setParameter('empresa', $empresa)
            ->getQuery()
            ->getResult();
    }

    public function findByTipo(TipoDispositivo $tipoDispositivo)
    {
        return $this->createQueryBuilder('s')
            ->where('s.tipo = :tipo')
            ->setParameter('tipo', $tipoDispositivo)
            ->getQuery()
            ->getResult();
    }

    public function findAllWithEmpresaAndTipoJoin()
    {
        return $this->createQueryBuilder('d')
            ->addSelect('e')
            ->addSelect('t')
            ->innerJoin('d.empresa', 'e')
            ->innerJoin('d.tipo', 't')
            ->getQuery()
            ->getResult();
    }
}