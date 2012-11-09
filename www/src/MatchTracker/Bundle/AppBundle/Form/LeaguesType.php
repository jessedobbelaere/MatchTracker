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
            ->add('location', 'choice', array('choices' => array('one' => 'Eén locatie', 'more' => 'Elke ploeg eigen terrein'),'label' => 'Locatie', 'attr' => array("onchange" => 'Javascript:myFunction();')))
            ->add('field', 'integer', array('label' => 'Aantal velden'))
            ->add('numberOfTeams', 'integer', array('label' => 'Aantal teams'))
            ->add('place', 'text', array('label' => 'Plaats'))
        ;

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $constraintCollection = array(
            'place' => new NotBlank(array('message' => 'Gelieve een plaats in te vullen')),
            'field' => new NotBlank(array('message' => 'Gelieve aantal velden in te geven')),
            'location' => new NotBlank(array('message' => 'Gelieve een locatie in te geven')),
            'numberOfTeams' => new NotBlank(array('message' => 'Gelieve een sport aan te duiden')));

        if ($this->type !== null) {
            if ($this->type->getPlayersOnField() == null) {
                $constraintCollection['playersOnField'] = new NotBlank(array('message' => 'Gelieve een sport aan te duiden'));
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
