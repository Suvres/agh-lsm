<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('author', TextType::class, [
                'label' => 'Autor'
            ])
            ->add('title', TextType::class, [
                'label' => 'Tytuł'
            ])
            ->add('ageThreshold', NumberType::class, [
                'label' => 'Granica wieku',
                'html5' => true
            ])
            ->add('brand', ChoiceType::class, [
                'label' => 'Gatunek',
                'choices' => Book::BOOK_BRANDS
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class
        ]);
    }
}
