<?php

namespace MatchTracker\Bundle\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Min;
use Symfony\Component\Validator\Constraints\Date;
use MatchTracker\Bundle\AppBundle\Form\EventListener\LeaguesSubscriber;

class LeaguesType extends AbstractType {

    private $formula;
    private $players;

    public function __construct($formula, $players) {
        $this->formula = $formula;
        $this->players = $players;
    }

    /**
     * Build Form action
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        if ($this->players !== null) {
            // If playersOnField is null, ask how many players
            $builder->add('playersOnField', 'integer', array('label' => 'Aantal spelers'));
        }

        // form
        $builder
            ->add('numberOfTeams', 'choice', array('empty_value' => 'Kies aantal ploegen', 'label' => 'Aantal ploegen', 'attr' => array("onchange" => 'Javascript:goingThroughFunction();')))
            ->add('groups', 'choice', array('empty_value' => 'Kies aantal groepen', 'label' => 'Aantal groepen','attr' => array("onchange" => 'Javascript:goingThroughFunction();')))
            ->add('goingThrough', 'choice', array('label' => 'Wie gaat door'))
            ->add('return', 'choice', array('expanded' => true, 'choices' => array(true => 'ja', false => 'nee'), 'label' => 'Heen en terug'))
        ;

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
	        $constraintCollection = array(
	            'numberOfTeams' => array(
	                new NotBlank(array('message' => 'Gelieve het aantal ploegen aan te duiden')),
	                new Min(array('limit' => '0', 'message' => 'Gelieve een positief getal in te vullen'))),
                'formula' => array(),
                'return' => array(),
                //'groups' => array(),
                'goingThrough' => array()
            );

	        if ($this->players !== null) {

	            $constraintCollection['playersOnField'] = array(
	                new NotBlank(array('message' => 'Gelieve een sport aan te duiden')),
	                new Min(array('limit' => '0', 'message' => 'Gelieve een positief getal in te vullen')));
	        }

	        $constraint = new Collection($constraintCollection);

	        $resolver->setDefaults(array(
	            'constraints' => $constraint
	        ));
	    }

	    public function getName() {
	        return 'matchtracker_appbundle_leaguestype';
    }
}
