<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
                ->add('titre', TextType::class, [
                    'required' => true,
                    'label' => 'Titre',
                    'attr' => array('placeholder' => 'Titre'),
                ])
                ->add('description', TextareaType::class, [
                    'required' => true,
                    'label' => 'Description',
                    'attr' => array('placeholder' => 'Description'),
                ])
                ->add('save', SubmitType::class, [
                    'label' => "Sauvegarder",
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }

}
