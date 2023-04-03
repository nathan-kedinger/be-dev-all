<?php

namespace App\Form;

use App\Entity\Languages;
use App\Entity\Mission;
use App\Repository\AudioRecordCategoriesRepository;
use App\Repository\LanguagesRepository;
use App\Repository\VoiceStyleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionFormType extends AbstractType
{
    private LanguagesRepository $languagesRepository;
    public function __construct(LanguagesRepository $languagesRepository)
    {
        $this->languagesRepository = $languagesRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Rechercher une mission',
                ],
            ])
            ->add('languages', EntityType::class, [
                'class' => Languages::class,
                'choices' => $this->languagesRepository->findAll(),
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true, // This will render checkboxes instead of a select element
                'label' => 'Langages',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
    public function getBlockPrefix(): string
    {
        return '';
    }
}
