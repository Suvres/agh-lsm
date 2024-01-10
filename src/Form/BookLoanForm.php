<?php

namespace App\Form;

use App\DTO\BookLoanDTO;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookLoanForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('user', EntityType::class, [
            'class' => User::class,
            'label' => 'Użytkownik',
            'placeholder' => 'Wybierz użytkownika',
            'choice_label' => 'email',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BookLoanDTO::class,
        ]);
    }
}
