<?php

namespace MatchTracker\Bundle\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TeamsType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('name', 'text', array('attr' => array('placeholder' => 'Teamnaam')))
				->add('email', 'text', array('attr' => array('placeholder' => 'Email')));
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array(
			'data_class' => 'MatchTracker\Bundle\AppBundle\Entity\Teams',
		));
	}

	public function getName() {
		return 'team';
	}

}
