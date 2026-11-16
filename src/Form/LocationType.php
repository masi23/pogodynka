<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'attr' => ['placeholder' => 'Podaj nazwę miasta'],
                'constraints' => [
                    new Assert\NotBlank(groups: ['new', 'edit']),
                    new Assert\Length(min: 2, max: 100, groups: ['new', 'edit']),
                ],
            ])
            ->add('state', ChoiceType::class, [
                'choices' => [
                    'dolnoslaskie' => 'dolnoslaskie',
                    'kujawsko-pomorskie' => 'kujawsko-pomorskie',
                    'lubelskie' => 'lubelskie',
                    'lubuskie' => 'lubuskie',
                    'lodzkie' => 'lodzkie',
                    'malopolskie' => 'malopolskie',
                    'mazowieckie' => 'mazowieckie',
                    'opolskie' => 'opolskie',
                    'podkarpackie' => 'podkarpackie',
                    'podlaskie' => 'podlaskie',
                    'pomorskie' => 'pomorskie',
                    'slaskie' => 'slaskie',
                    'swietokrzyskie' => 'Swietokrzyskie',
                    'warminsko-mazurskie' => 'warminsko-mazurskie',
                    'wielkopolskie' => 'wielkopolskie',
                    'zachodniopomorskie' => 'zachodniopomorskie',
                ],
                'constraints' => [
                    new Assert\NotBlank(groups: ['new', 'edit']),
                ],
            ])
            ->add('lon', NumberType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(groups: ['new', 'edit']),
                    new Assert\Range(min: -180, max: 180, groups: ['new', 'edit']),
                ],
            ])
            ->add('lat', NumberType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(groups: ['new', 'edit']),
                    new Assert\Range(min: -90, max: 90, groups: ['new', 'edit']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
