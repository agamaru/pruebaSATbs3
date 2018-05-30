<?php
/**
 * Created by PhpStorm.
 * User: elsiore
 * Date: 22/05/18
 * Time: 19:38
 */

namespace AppBundle\Form\Type;


use AppBundle\Entity\TipoSoftware;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TipoSoftwareType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', null, [
                'label' => 'Nombre *'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TipoSoftware::class
        ]);
    }
}