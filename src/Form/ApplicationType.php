<?php

namespace App\Form;

use App\Entity\Advert;
use App\Entity\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author', TextType::class, [
                'required' => true,
                'label' => 'platform.application.form.field.author'
            ])
            ->add('content', TextareaType::class, [
                'required' => true,
                'label' => 'platform.application.form.field.content'
            ])
            ->add('advert', EntityType::class, [
                'required' => true,
                'label' => 'platform.application.form.field.advert',
                'class' => Advert::class,
                'choice_label' => function ($advert) {
                    return '#' . $advert->getId() . ' - ' . $advert->getTitle();
                },
                'multiple' => false,
                'expanded' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
