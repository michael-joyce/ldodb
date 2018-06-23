<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * OrganizationType form.
 */
class OrganizationType extends AbstractType
{
    /**
     * Add form fields to $builder.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {        $builder->add('organizationName', null, array(
            'label' => 'Organization Name',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
                $builder->add('organizationUri', null, array(
            'label' => 'Organization Uri',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
                $builder->add('organizationNotes', null, array(
            'label' => 'Organization Notes',
            'required' => false,
            'attr' => array(
                'help_block' => '',
            ),
        ));
        
    }
    
    /**
     * Define options for the form.
     *
     * Set default, optional, and required options passed to the
     * buildForm() method via the $options parameter.
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Organization'
        ));
    }

}
