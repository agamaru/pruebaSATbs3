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

class EmpresaRepository extends EntityRepository
{
    public function delete(Empresa $empresa)
    {
        $this->getEntityManager()
            ->createQuery('DELETE AppBundle:ConfiRed c WHERE c.empresa = :empresa')
            ->setParameter('empresa', $empresa)
            ->execute();

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

        $this->getEntityManager()->remove($empresa);

    }
}