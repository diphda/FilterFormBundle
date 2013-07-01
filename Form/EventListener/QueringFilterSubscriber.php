<?php 

namespace IDCI\Bundle\FilterFormBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;

class QueringFilterSubscriber implements EventSubscriberInterface
{
    private $factory;
    private $filterManager;

    public function __construct(FormFactoryInterface $factory, $filterManager)
    {
        $this->factory = $factory;
        $this->filterManager = $filterManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::POST_SUBMIT => 'updateFilters',
        );
    }

    public function updateFilters(DataEvent $event)
    {
        $data = $event->getData();
        $this->filterManager->setQueryingFilters(self::cleanData($data));
    }

    /**
     * cleanData
     *
     * @param array all form data
     * @return array entered form data
     */
    public static function cleanData($data)
    {
        $cleanData = array();

        foreach($data as $field => $d) {
            if(count($d) > 0) {
                $cleanData[$field] = $d;
            }
        }

        return $cleanData;
    }
}
