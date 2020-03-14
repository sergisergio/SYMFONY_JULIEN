<?php

namespace App\Form;

use App\Entity\Advert;
use App\Form\ImageType;
use App\Form\AdvertSkillType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertType extends AbstractType
{
    /**
     * @see https://symfony.com/doc/current/form/form_collections.html
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'platform.advert.form.field.title'
            ])
            ->add('author', TextType::class, [
                'required' => true,
                'label' => 'platform.advert.form.field.author'
            ])
            ->add('content', TextareaType::class, [
                'required' => true,
                'label' => 'platform.advert.form.field.content'
            ])
            ->add('published', CheckboxType::class, [
                'required' => false,
                'label' => 'platform.advert.form.field.published'
            ])
            ->add('image', ImageType::class)
            ->add('skills', CollectionType::class, [
                'label' => 'platform.advert.form.field.skills',
                'entry_type' => AdvertSkillType::class,
                'entry_options' => ['label' => false],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Advert::class,
        ]);
    }
}
