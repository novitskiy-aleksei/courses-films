<?php

namespace Films\CatalogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FilmType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('picture')
            ->add('description')
            ->add('date')
            ->add('categories')
            ->add('director', new DirectorType())
            ->add('actors')
            ->add('save', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Films\CatalogBundle\Entity\Film',
            'validation_groups' => 'film'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'films_catalogbundle_film';
    }
}
