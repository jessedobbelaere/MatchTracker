<?php

namespace MatchTracker\AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		//parent::buildForm($builder, $options);

		// add your custom field
		$builder
			->add('username', null, array('translation_domain' => 'FOSUserBundle', 'label' => ' ', 'attr' => array('placeholder' => 'Gebruikersnaam', 'class' => 'largeInput')))
			->add('email', 'email', array('translation_domain' => 'FOSUserBundle', 'label' => ' ', 'attr' => array('placeholder' => 'E-mailadres', 'class' => 'largeInput')))
			->add('plainPassword', 'repeated', array(
			'type' => 'password',
			'options' => array('translation_domain' => 'FOSUserBundle'),
			'first_options' => array('label' => ' ', 'attr' => array('placeholder' => 'Paswoord', 'class' => 'largeInput')),
			'second_options' => array('label' => ' ', 'attr' => array('placeholder' => 'Paswoord', 'class' => 'largeInput')),
			'invalid_message' => 'fos_user.password.mismatch',
		))
		;
	}

	public function getName()
	{
		return 'matchtracker_registration_form';
	}
}