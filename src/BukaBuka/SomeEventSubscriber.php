<?php


namespace App\BukaBuka;


use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class SomeEventSubscriber implements EventSubscriberInterface
{

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
            $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
            RequestEvent::class => 'sukaSobakas',
            ControllerEvent::class => 'controllerEvent'
        ];
    }

    public function sukaSobakas(RequestEvent $event){

        $request = $event->getRequest();

        $userAgent = $request->headers->get('User-Agent');
        $this->logger->info(sprintf('The yashin pisos user is "%s"', $userAgent));
    }

    public function controllerEvent(){
        $this->logger->info('Yashimn pisiso controller event');
    }
}