<?php

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
        if (false === $options['nuevo']) {
            $builder
                ->add('empresa', null, [
                    'label' => 'Empresa *',
                    //'disabled' => !$options['admin']
                    'disabled' => $options['permiso']
                ]);
        } else {
            $builder
                ->add('empresa', EntityType::class, [
                    'class' => Empresa::class,
                    'placeholder' => 'Seleccione una empresa',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('e')
                            ->orderBy('e.nombre');
                    },
                    'label' => 'Empresa *'
                ]);
        }

        $builder
            ->add('dominio', null, [
                'label' => 'Dominio *',
                'disabled' => $options['permiso']
            ])
            ->add('mascaraRed', null, [
                'label' => 'Máscara de red *',
                'disabled' => $options['permiso']
            ])
            ->add('ipFijaExt', null, [
                'label' => 'IP fija externa *',
                'disabled' => $options['permiso']
            ])
            ->add('dns1', null, [
                'label' => 'DNS1 *',
                'disabled' => $options['permiso']
            ])
            ->add('dns2', null, [
                'label' => 'DNS2 *',
                'disabled' => $options['permiso']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ConfiRed::class,
            'nuevo' => false,
            'admin' => false,
            'permiso' => false,
            'translation_domain' => false
        ]);
    }
}