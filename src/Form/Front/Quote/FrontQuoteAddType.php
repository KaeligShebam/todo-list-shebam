<?php

namespace App\Form\Front\Quote;

use App\Entity\User;
use App\Entity\Quote;
use App\Entity\Status;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FrontQuoteAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('enterprise', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entreprise',
                    'class' => ' form-control is-invalid'
                ]
            ])
            ->add('subject', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Sujet',
                    'class' => ' form-control is-invalid'
                ]
            ])
            ->add('comment', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Remarque',
                    'class' => ' form-control is-invalid'
                ]
            ])
            ->add('person', EntityType::class, array(
                'required' => true,
                'label' => 'Personne(s) Désigné(e): ',
                'class' => User::class,
                'multiple' => true,
                'expanded' => true,
                'label_attr' => ['class' => 'label-custom'],
            ))
            ->add('status', EntityType::class, array(
                'required' => true,
                'label' => 'Statut :',
                'class' => Status::class,
                'label_attr' => ['class' => 'label-custom'],
            ))
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => ['class' => 'btn-submit-front-shebam'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quote::class,
        ]);
    }
}