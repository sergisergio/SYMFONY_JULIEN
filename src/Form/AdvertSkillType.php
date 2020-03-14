<?php

namespace App\Form;

use App\Entity\AdvertSkill;
use App\Entity\Advert;
use App\Entity\Skill;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AdvertSkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('skill', EntityType::class, [
                'required' => true,
                'label' => 'platform.advert_skill.form.field.skill',
                'class' => Skill::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false
            ])
            ->add('level', ChoiceType::class, [
                'required' => true,
                'label' => 'platform.advert_skill.form.field.level',
                'choices'  => [
                    'platform.advert_skill.form.field.level_choice.label_1' => 1,
                    'platform.advert_skill.form.field.level_choice.label_2' => 2,
                    'platform.advert_skill.form.field.level_choice.label_3' => 3,
                    'platform.advert_skill.form.field.level_choice.label_4' => 4,
                    'platform.advert_skill.form.field.level_choice.label_5' => 5
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AdvertSkill::class,
        ]);
    }
}
