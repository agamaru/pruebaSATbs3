<?php
/**
 * Created by PhpStorm.
 * User: elsiore
 * Date: 21/05/18
 * Time: 20:27
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Empresa;
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
}