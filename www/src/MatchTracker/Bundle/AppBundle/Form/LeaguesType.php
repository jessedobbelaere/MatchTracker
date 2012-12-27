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
        // form
        $builder
            ->add('numberOfTeams', 'choice', array('empty_value' => 'Kies aantal ploegen', 'label' => 'Aantal ploegen', 'choices' => $this->generateNumberOfTeams()))
            ->add('return', 'choice', array('expanded' => true, 'choices' => array(true => 'ja', false => 'nee'), 'label' => 'Heen en terug'))
        ;

        // if formula is classement with knockout
        if ($this->formula === "beide") {
            $builder
                ->add('numGroups', 'choice', array('empty_value' => 'Kies aantal groepen', 'label' => 'Aantal groepen', 'choices' => array(
                    '2' => 2, '4' => 4, '8' => 8
            )))
                ->add('goingThrough', 'choice', array('empty_value' => 'Wie gaat er door', 'label' => 'Wie gaat door', 'choices' => array(
                    1 => 'Winnaar', 2 => 'Eerste 2', 4 => 'Eerste 4'
            )))
            ;
        }

        // If playersOnField is null, ask how many players
        if ($this->players) {
            $builder->add('playersOnField', 'integer', array('label' => 'Aantal spelers'));
            $builder->add('playTime', 'integer', array('label' => 'Minuten per helft'));
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $constraintCollection = array(
            'numberOfTeams' => array(
                new NotBlank(array('message' => 'Gelieve het aantal ploegen aan te duiden')),
                new Min(array('limit' => '0', 'message' => 'Gelieve een positief getal in te vullen'))),
            'return' => array(
                new NotBlank(array('message' => 'Gelieve een keuze te maken'))
            )
        );

        if ($this->players) {
            $constraintCollection['playersOnField'] = array(
                new NotBlank(array('message' => 'Gelieve een sport aan te duiden')),
                new Min(array('limit' => '0', 'message' => 'Gelieve een positief getal in te vullen')));

            $constraintCollection['playTime'] = array(
                new NotBlank(array('message' => 'Gelieve aantal minuten in te vullen')));

        }

        if ($this->formula === "beide") {
            $constraintCollection['numGroups'] = array(
                new NotBlank(array('message' => 'Gelieve aantal groepen in te vullen')));
            $constraintCollection['goingThrough'] = array(
                new NotBlank(array('message' => 'Gelieve aan te duiden wie door gaat')));
        }

        $constraint = new Collection($constraintCollection);

        $resolver->setDefaults(array(
            'constraints' => $constraint
        ));
    }

	public function getName() {
	        return 'matchtracker_appbundle_leaguestype';
    }


    public function generateNumberOfTeams() {
        $toReturn = array();
        if ($this->formula === "klassement") {
            for ($i = 2; $i <= 20; $i++) {
                $toReturn['' + $i] = $i;
            }
        } else if ($this->formula === "knockout") {
            for ($i = 2; $i <= 36; $i*=2) {
                $toReturn['' + $i] = $i;
            }
        } else if ($this->formula === "beide") {
            for ($i = 2; $i <= 40; $i+=2) {
                $toReturn['' + $i] = $i;
            }
        }

        return $toReturn;
    }
}
