<?php

namespace AppBundle\Form\Type;


use AppBundle\Entity\Empresa;
use AppBundle\Entity\Software;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SoftwareType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (false === $options['nuevo']) {
            $builder
                ->add('empresa', null, [
                    'label' => 'Empresa *',
                    'disabled' => !$options['admin']
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
            ->add('nombre', null, [
                'label' => 'Nombre del software *'
            ])
            ->add('tipo', null, [
                'label' => 'Tipo *',
                'placeholder' => 'Seleccione un tipo'
            ])
            ->add('usuario', null, [
                'label' => 'Usuario *'
            ])
            ->add('password', null, [
                'label' => 'Contraseña *'
            ])
            ->add('notas', null, [
                'label' => 'Notas'
            ])
            ->add('fechaRenovacion', null, [
                'label' => 'Fecha de renovación *',
                'widget' => 'single_text'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Software::class,
            'nuevo' => false,
            'admin' => false

        ]);
    }
}