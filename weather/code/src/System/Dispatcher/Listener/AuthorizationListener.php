<?php
namespace App\System\Dispatcher\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class AuthorizationListener implements EventSubscriberInterface
{
    /** @var string */
    private $header;
    /** @var string */
    private $token;
    
    /**
     * AuthorizationListener constructor.
     *
     * @param string $serviceAuthHeader
     * @param string $serviceAuthToken
     */
    public function __construct(string $serviceAuthHeader, string $serviceAuthToken)
    {
        $this->header = $serviceAuthHeader;
        $this->token = $serviceAuthToken;
    }
    
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest'
        ];
    }
    
    /**
     * @param RequestEvent $event
     */
    public function onKernelRequest(RequestEvent $event)
    {
        $tokenFromHeader = $event->getRequest()->headers->get($this->header, null);
        if (empty($tokenFromHeader) || $this->token !== $tokenFromHeader) {
            throw new AccessDeniedHttpException("Access denied", null, -32000);
        }
    }
    
    
}
