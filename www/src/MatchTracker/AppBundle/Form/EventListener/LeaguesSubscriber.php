<?php
namespace MatchTracker\AppBundle\Form\EventListener;

use Symfony\Component\Form\Event\DataEvent;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;

/**
 * Created by JetBrains PhpStorm.
 * User: Bert
 * Date: 6/11/12
 * Time: 1:35
 * To change this template use File | Settings | File Templates.
 */
class LeaguesSubscriber implements EventSubscriberInterface {
    private $factory;

    public function __construct(FormFactoryInterface $factory) {
        $this->factory = $factory;
    }

    public static function getSubscribedEvents() {
        // Tells the dispatcher that we want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::POST_SET_DATA => 'postSetData');
    }

    public function postSetData(DataEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        // During form creation setData() is called with null as an argument
        if (null === $data) {
            return;
        }

        // check if the product object is "new"
        if ($data!== null) {
            $form->add($this->factory->createNamed('name', 'text'));
        }
    }
}