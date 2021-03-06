<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Empresa;
use Doctrine\ORM\EntityRepository;

class ConfiRedRepository extends EntityRepository
{
    public function findByEmpresa(Empresa $empresa)
    {
        return $this->createQueryBuilder('c')
            ->where('c.empresa = :empresa')
            ->setParameter('empresa', $empresa)
            ->getQuery()
            ->getResult();
    }

    public function findAllWithEmpresaJoin()
    {
        return $this->createQueryBuilder('c')
            ->addSelect('e')
            ->innerJoin('c.empresa', 'e')
            ->getQuery()
            ->getResult();
    }
}