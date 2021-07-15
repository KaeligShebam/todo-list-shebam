<?php

namespace App\Form\Front\Task;

use App\Entity\Task;
use App\Entity\User;
use App\Entity\Status;
use App\Entity\Statut;
use App\Entity\Customer;
use App\Entity\Appointment;
use App\Form\UserMultipleType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class FrontAppointmentAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name',  TextType::class, [
            'required' => true,
            'label' => false,
            'attr' => [
                'placeholder' => 'Intitulé du rendez-vous',
                'class' => ' form-control is-invalid'
            ]
        ])
        ->add('subject',  TextType::class, [
            'required' => true,
            'label' => false,
            'attr' => [
                'placeholder' => 'Sujet',
                'class' => ' form-control is-invalid'
            ]
        ])
        ->add('hoursappointment', DateTimeType::class, [
            'label' => 'Heure du rendez-vous :',
            'label_attr' => ['class' => 'label-custom'],
            'days' => range(1,31),
            'years' => range(2021,2022),
            'hours' => range(7,18),
            'minutes' => range(0,59),
        ])
        ->add('user', EntityType::class, array(
            'required' => true,
            'label' => 'Personne(s) :',
            'class' => User::class,
            'multiple' => true,
            'expanded' => true,
            'label_attr' => ['class' => 'label-custom'],
        ))
        ->add('statut', EntityType::class, array(
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

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}