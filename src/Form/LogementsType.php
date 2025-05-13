<?php

namespace App\Form;

use App\Entity\Logements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LogementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
                'attr' => ['class' => 'form-control']
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'attr' => ['class' => 'form-control']
            ])
            ->add('surface', IntegerType::class, [
                'label' => 'Surface (m²)',
                'attr' => ['class' => 'form-control']
            ])
            ->add('loyer', IntegerType::class, [
                'label' => 'Loyer (€)',
                'attr' => ['class' => 'form-control']
            ])
            ->add('charges', IntegerType::class, [
                'label' => 'Charges (€)',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control', 'rows' => 5]
            ])
            ->add('nb_place', IntegerType::class, [
                'label' => 'Nombre de places',
                'attr' => ['class' => 'form-control']
            ])
            ->add('date_ajout', DateType::class, [
                'label' => 'Date d\'ajout',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Logements::class,
        ]);
    }
} 