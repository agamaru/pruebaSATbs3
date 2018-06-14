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
        $confiRedes = $this->getEntityManager()
            ->getRepository('AppBundle:ConfiRed')
            ->findByEmpresa($empresa);

        foreach($confiRedes as $confiRed) {
            $this->getEntityManager()->remove($confiRed);
        }

        $dispositivos = $this->getEntityManager()
            ->getRepository('AppBundle:DispositivoRed')
            ->findByEmpresa($empresa);

        foreach($dispositivos as $dispositivo) {
            $this->getEntityManager()->remove($dispositivo);
        }

        $servidores = $this->getEntityManager()
            ->getRepository('AppBundle:Servidor')
            ->findByEmpresa($empresa);

        foreach($servidores as $servidor) {
            $this->getEntityManager()->remove($servidor);
        }

        $softwares = $this->getEntityManager()
            ->getRepository('AppBundle:Software')
            ->findByEmpresa($empresa);

        foreach($softwares as $software) {
            $this->getEntityManager()->remove($software);
        }

        $this->getEntityManager()->remove($empresa);

    }
}