<?php

namespace StoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class OpinionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('author', 'text', array('label' => "Votre nom"));
        $builder->add('content', 'textarea', array('label' => "Votre avis"));
    }

    public function getName()
    {
        return 'opinion_form';
    }

}
