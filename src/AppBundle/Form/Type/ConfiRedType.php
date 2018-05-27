<?php
/**
 * Created by PhpStorm.
 * User: elsiore
 * Date: 22/05/18
 * Time: 19:38
 */

namespace AppBundle\Form\Type;


use AppBundle\Entity\ConfiRed;
use AppBundle\Entity\Empresa;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfiRedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (false !== $options['tengoEmpresa']) {
            $builder
                ->add('empresa', null, [
                    'label' => 'Empresa',
                    'disabled' => true
                ]);
        } else {
            $builder
                ->add('empresa', EntityType::class, [
                    'class' => Empresa::class,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('e')
                            ->orderBy('e.nombre');
                    },
                    'label' => 'Empresa'
                ]);
        }

        $builder
            ->add('dominio', null, [
                'label' => 'Dominio'
            ])
            ->add('mascaraRed', null, [
                'label' => 'Máscara de red'
            ])
            ->add('ipFijaExt', null, [
                'label' => 'IP fija externa'
            ])
            ->add('dns1', null, [
                'label' => 'DNS'
            ])
            ->add('dns2', null, [
                'label' => 'DNS2'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ConfiRed::class,
            'tengoEmpresa' => false
        ]);
    }
}