<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', 'text', array('label' => "Prénom"));
        $builder->add('lastName', 'text', array('label' => "Nom"));
        $builder->add('email', 'email', array('label' => "Email"));
        $builder->add('message', 'textarea', array('label' => "Message"));
    }
    
    public function getName()
    {
        return 'contact_form';
    }

}
