<?php

namespace App\Form;


use App\Entity\Annonces;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AnnoncesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class, [
                'attr'=>['class'=>'form-control'],
                'label'=>'Title',
                'label_attr'=>[
                    'class'=>'form-label mt-4'],
                    'constraints'=>[
                        new LessThan(50)
                    ],])
            ->add('submit', SubmitType::class , [
                        'attr'=>['class'=>'btn btn-primary mt-4'],
                        'label'=>'Creation une Annonce',
                        
                    ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }
}
