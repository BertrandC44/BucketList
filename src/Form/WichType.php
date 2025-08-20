<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Wish;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WichType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'class' => Category::class,
                'placeholder' => '-- Choisir une catégorie --',
                'choice_label' => 'name',
                'query_builder' => function (CategoryRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');
                }
            ])
            ->add('title', TextType::class, [
                'label' => 'Nom du souhait',
                'required' => true
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description du souhait',
                'required' => false
            ])
            ->add('author', TextType::class, [
                'label' => 'Nom de l\'auteur',
                'required' => true
            ])
            ->add('isPublished', CheckboxType::class, [
                'required' => false,
                'data'=>true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
        ]);
    }
}
