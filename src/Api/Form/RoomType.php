<?php


namespace App\Api\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('entry_date', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'input-sm form-control start'],
            ])
            ->add('exit_date', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'input-sm form-control end'],
            ])
            ->add('guests', NumberType::class, [
                'label' => 'Huéspedes',
                'attr' => ['class' => 'form-control'],
            ]);
    }

}