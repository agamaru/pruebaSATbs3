<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Empresa;
use Doctrine\ORM\EntityRepository;

class ServidorRepository extends EntityRepository
{
    public function findByEmpresa(Empresa $empresa)
    {
        return $this->createQueryBuilder('s')
            ->where('s.empresa = :empresa')
            ->setParameter('empresa', $empresa)
            ->getQuery()
            ->getResult();
    }

    public function findAllWithEmpresaJoin()
    {
        return $this->createQueryBuilder('s')
            ->addSelect('e')
            ->innerJoin('s.empresa', 'e')
            ->getQuery()
            ->getResult();
    }
}