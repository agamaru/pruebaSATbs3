<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Empresa;
use AppBundle\Entity\TipoDispositivo;
use Doctrine\ORM\EntityRepository;

class DispositivoRedRepository extends EntityRepository
{
    public function findByQueryBuilder()
    {
        return $this->createQueryBuilder('d')
            ->addSelect('e')
            ->innerJoin('d.empresa', 'e');
    }

    public function findByEmpresa(Empresa $empresa)
    {
        return $this->createQueryBuilder('d')
            ->addSelect('t')
            ->innerJoin('d.tipo', 't')
            ->where('d.empresa = :empresa')
            ->setParameter('empresa', $empresa)
            ->getQuery()
            ->getResult();
    }

    public function findByTipo(TipoDispositivo $tipoDispositivo)
    {
        return $this->findByQueryBuilder()
            ->where('d.tipo = :tipo')
            ->setParameter('tipo', $tipoDispositivo)
            ->getQuery()
            ->getResult();
    }

    public function findAllWithEmpresaAndTipoJoin()
    {
        return $this->findByQueryBuilder()
            ->addSelect('t')
            ->innerJoin('d.tipo', 't')
            ->getQuery()
            ->getResult();
    }
}