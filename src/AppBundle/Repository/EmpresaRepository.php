<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Empresa;
use Doctrine\ORM\EntityRepository;

class EmpresaRepository extends EntityRepository
{
    public function findAllOrderedByNombre()
    {
        return $this->createQueryBuilder('e')
            ->addOrderBy('e.nombre')
            ->getQuery()
            ->getResult();
    }

    public function delete(Empresa $empresa)
    {
        $confiReds = $this->getEntityManager()
            ->getRepository('AppBundle:ConfiRed')->findByEmpresa($empresa);

        foreach($confiReds as $confiRed) {
            $this->getEntityManager()->remove($confiRed);
        }

        $this->getEntityManager()
            ->createQuery('DELETE AppBundle:DispositivoRed d WHERE d.empresa = :empresa')
            ->setParameter('empresa', $empresa)
            ->execute();

        $this->getEntityManager()
            ->createQuery('DELETE AppBundle:Servidor s WHERE s.empresa = :empresa')
            ->setParameter('empresa', $empresa)
            ->execute();

        $this->getEntityManager()
            ->createQuery('DELETE AppBundle:Software s WHERE s.empresa = :empresa')
            ->setParameter('empresa', $empresa)
            ->execute();

    }
}