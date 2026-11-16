<?php

namespace App\Form;

use App\Entity\Forecast;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ForecastType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder

            ->add('date', DateType::class, [
                'label' => 'Data prognozy',
                'widget' => 'single_text',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Podaj datę prognozy.',
                    ], groups: ['new', 'edit']),
                ],
            ])

            ->add('temperature', NumberType::class, [
                'label' => 'Temperatura (°C)',
                'required' => true,
                'scale' => 1,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Podaj temperaturę.',
                    ]),
                    new Assert\Range([
                        'min' => -100,
                        'max' => 60,
                        'notInRangeMessage' =>
                            'Temperatura musi być od {{ min }} do {{ max }} °C.',
                    ], groups: ['new', 'edit']),
                ],
            ])

            ->add('rain_mm', NumberType::class, [
                'label' => 'Opady (mm)',
                'required' => true,
                'scale' => 2,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Podaj ilość opadów.',
                    ], groups: ['new', 'edit']),
                    new Assert\Range([
                        'min' => 0,
                        'max' => 1000,
                        'notInRangeMessage' =>
                            'Opady muszą być od {{ min }} do {{ max }} mm.',
                    ], groups: ['new', 'edit']),
                ],
            ])

            ->add('description', TextareaType::class, [
                'label' => 'Opis pogody',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Podaj opis pogody.',
                    ], groups: ['new', 'edit']),
                    new Assert\Length([
                        'min' => 5,
                        'max' => 500,
                        'minMessage' =>
                            'Opis musi mieć minimum {{ limit }} znaków.',
                        'maxMessage' =>
                            'Opis może mieć maksymalnie {{ limit }} znaków.',
                    ], groups: ['new', 'edit']),
                ],
            ])

            ->add('pressure', IntegerType::class, [
                'label' => 'Ciśnienie (hPa)',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Podaj ciśnienie.',
                    ], groups: ['new', 'edit']),
                    new Assert\Range([
                        'min' => 800,
                        'max' => 1100,
                        'notInRangeMessage' =>
                            'Ciśnienie musi być od {{ min }} do {{ max }} hPa.',
                    ], groups: ['new', 'edit']),
                ],
            ])

            ->add('humidity', IntegerType::class, [
                'label' => 'Wilgotność (%)',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Podaj wilgotność.',
                    ], groups: ['new', 'edit']),
                    new Assert\Range([
                        'min' => 0,
                        'max' => 100,
                        'notInRangeMessage' =>
                            'Wilgotność musi być od {{ min }} do {{ max }}%.',
                    ], groups: ['new', 'edit']),
                ],
            ])

            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'id',
                'label' => 'Lokalizacja',
                'placeholder' => 'Wybierz lokalizację',
                'required' => true,
                'constraints' => [
                    new Assert\NotNull([
                        'message' => 'Wybierz lokalizację.',
                    ], groups: ['new', 'edit']),
                ],
            ]);
    }

    public function configureOptions(
        OptionsResolver $resolver
    ): void {
        $resolver->setDefaults([
            'data_class' => Forecast::class,
        ]);
    }
}
