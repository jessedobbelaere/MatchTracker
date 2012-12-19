<?php

namespace MatchTracker\Bundle\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Date;
use MatchTracker\Bundle\AppBundle\Form\EventListener\LeaguesSubscriber;

class LeaguesType extends AbstractType {

    private $sport;
    private $type;

    public function __construct($sport, $type) {
        $this->sport = $sport;
        $this->type = $type;
    }

    /**
     * Build Form action
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        if ($this->type !== null) {
            // If playersOnField is null, ask how many players
            if ($this->type->getPlayersOnField() == null) {
                $builder->add('playersOnField', 'integer', array('label' => 'Aantal spelers'));
            }
        }

        // form
		        $builder
		            ->add('location', 'choice', array('choices' => array('one' => 'Eén locatie', 'more' => 'Elke ploeg eigen terrein'),'label' => 'Locatie', 'attr' => array("onchange" => 'Javascript:locationFunction();')))
		            ->add('field', 'integer', array('label' => 'Aantal velden', 'attr' => array()))
		            ->add('numberOfTeams', 'choice', array('empty_value' => 'Kies aantal ploegen', 'label' => 'Aantal ploegen', 'attr' => array("onchange" => 'Javascript:goingThroughFunction();')))
		            ->add('place', 'text', array('label' => 'Adres'))
		            ->add('groups', 'number', array('label' => 'Aantal groepen','attr' => array("onchange" => 'Javascript:goingThroughFunction();')))
		            ->add('goingThrough', 'choice', array('label' => 'Wie gaat door'))
		            ->add('formula', 'choice', array('empty_value' => 'Kies formule', 'choices' => array('1' => 'Klassement', '2' => 'Knock-out', '3' => 'Klassement + Knock-out' ),'label' => 'Formule', 'attr' => array("onchange" => 'Javascript:formulaFunction();')))
		            ->add('return', 'choice', array('expanded' => true, 'choices' => array(true => 'ja', false => 'nee'), 'label' => 'Heen en terug'))

        ;

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
	        $constraintCollection = array(
	            'field' => array(
	                new NotBlank(array('message' => 'Gelieve aantal velden in te vullen')),
	                new Min(array('limit' => '0', 'message' => 'Gelieve een positief getal in te vullen'))),
	            'place' => new NotBlank(array('message' => 'Gelieve een plaats in te vullen')),
	            'location' => new NotBlank(array('message' => 'Gelieve een locatie in te geven')),
	            'numberOfTeams' => array(
	                new NotBlank(array('message' => 'Gelieve een sport aan te duiden')),
	                new Min(array('limit' => '0', 'message' => 'Gelieve een positief getal in te vullen'))));

	        if ($this->type !== null) {
	            if ($this->type->getPlayersOnField() == null) {
	                $constraintCollection['playersOnField'] = array(
	                    new NotBlank(array('message' => 'Gelieve een sport aan te duiden')),
	                    new Min(array('limit' => '0', 'message' => 'Gelieve een positief getal in te vullen')));
	            }
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
