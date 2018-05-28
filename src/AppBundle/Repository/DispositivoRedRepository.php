<?php
/**
 * Created by PhpStorm.
 * User: elsiore
 * Date: 22/05/18
 * Time: 18:37
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Empresa;
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
}