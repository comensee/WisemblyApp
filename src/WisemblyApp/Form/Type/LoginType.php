<?php

namespace Application\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email', array('required' => true));
        $builder->add('password', 'password', array('required' => true));
    }

    public function getName()
    {
        return 'login';
    }
}
