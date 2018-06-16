<?php

namespace AppBundle\Form\Type;


use AppBundle\Entity\DispositivoRed;
use AppBundle\Entity\Empresa;
use AppBundle\Entity\TipoDispositivo;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DispositivoRedType extends AbstractType
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
            ->add('tipo', EntityType::class, [
                'class' => TipoDispositivo::class,
                'placeholder' => 'Seleccione un tipo',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.nombre');
                },
                'label' => 'Tipo *',
                'disabled' => $options['permiso']
            ])
            ->add('ip', null, [
                'label' => 'IP *',
                'disabled' => $options['permiso']
            ])

            ->add('usuario', null, [
                'label' => 'Usuario *',
                'disabled' => $options['permiso']
            ])
            ->add('password', null, [
                'label' => 'Contraseña *',
                'disabled' => $options['permiso']
            ])
            ->add('wep', null, [
                'label' => 'Clave de encriptación *',
                'disabled' => $options['permiso']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DispositivoRed::class,
            'nuevo' => false,
            'admin' => false,
            'permiso' => false,
            'translation_domain' => false
        ]);
    }
}