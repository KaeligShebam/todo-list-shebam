<?php

namespace App\Form\Back\Task;

use App\Entity\User;
use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Customer;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AddTaskCurrentWeekType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('customer', EntityType::class, array(
            'required' => true,
            'label' => 'Sujet',
            'class' => Customer::class,
            'attr' => [
                'class' => 'select-customer'
            ],
            'label_attr' => ['class' => 'label-custom'],
            'query_builder' => function(EntityRepository $er){
                return $er->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');
            }
        ))
        ->add('object',  TextType::class, [
            'required' => true,
            'label' => false,
            'attr' => [
                'placeholder' => 'Objet',
                'class' => ' form-control is-invalid'
            ]
        ])
        ->add('subobject1',  TextType::class, [
            'required' => false,
            'label' => false,
            'attr' => [
                'placeholder' => 'Sous-Objet 1',
                'class' => ' form-control is-invalid'
            ]
        ])
        ->add('subobject2',  TextType::class, [
            'required' => false,
            'label' => false,
            'attr' => [
                'placeholder' => 'Sous-Objet 2',
                'class' => ' form-control is-invalid'
            ]
        ])
        ->add('subobject3',  TextType::class, [
            'required' => false,
            'label' => false,
            'attr' => [
                'placeholder' => 'Sous-Objet 3',
                'class' => ' form-control is-invalid'
            ]
        ])
        ->add('users', EntityType::class, array(
            'required' => true,
            'label' => 'Personne(s)',
            'class' => User::class,
            'multiple' => true,
            'label_attr' => ['class' => 'label-custom'],
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.firstname', 'ASC');
            }
            
        ))
        ->add('p1',  CheckboxType::class, [
            'required' => false,
            'label' => 'P1',
            'attr' => [
                'placeholder' => 'P1',
            ]
        ])
        ->add('p2',  CheckboxType::class, [
            'required' => false,
            'label' => 'P2',
            'attr' => [
                'placeholder' => 'P2',
            ]
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Enregistrer',
            'attr' => ['class' => 'btn-submit-back'],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}