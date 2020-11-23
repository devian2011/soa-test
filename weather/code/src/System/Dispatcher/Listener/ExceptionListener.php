<?php

namespace App\System\Dispatcher\Listener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final class ExceptionListener
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    
    /**
     * ExceptionListener constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $request = $event->getRequest();
        $data = json_decode($request->getContent(), true);
        $exception = $event->getThrowable();
        $response = new JsonResponse([
            'json-rpc' => '2.0',
            'id'       => isset($data['id']) ? $data['id'] : null,
            'errors'   => [
                'message' => $exception->getMessage(),
                'code'    => $exception->getCode(),
            ],
        ]);
        
        $this->logger->critical($exception);
        $event->setResponse($response);
    }
}
