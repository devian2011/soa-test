<?php

namespace App\IO\JsonRpc\Handlers\TemperatureForDate;

use App\Repository\UnknownTemperatureHistoryException;
use App\Services\Temperature\TemperatureHistoryGetter;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Yoanm\JsonRpcServer\Domain\Exception\JsonRpcException;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;

/**
 * Class Handler
 *
 * @package App\IO\JsonRpc\Handlers\TemperatureForDate
 */
class Handler implements JsonRpcMethodInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;
    
    /**
     * @var TemperatureHistoryGetter
     */
    private $finder;
    
    /**
     * @var LoggerInterface
     */
    private $logger;
    
    /**
     * Handler constructor.
     *
     * @param ValidatorInterface       $validator
     * @param TemperatureHistoryGetter $historyGetter
     * @param LoggerInterface          $logger
     */
    public function __construct(ValidatorInterface $validator, TemperatureHistoryGetter $historyGetter, LoggerInterface $logger)
    {
        $this->validator = $validator;
        $this->finder = $historyGetter;
        $this->logger = $logger;
    }
    
    /**
     * @param array|null $paramList
     *
     * @return mixed|void
     * @throws JsonRpcException
     */
    public function apply(array $paramList = null)
    {
        $request = new Request($paramList);
        $errors = $this->validator->validate($request);
        if (sizeof($errors) > 0) {
            throw new JsonRpcException(-32602, "Invalid params", call_user_func(static function () use ($errors) {
                $result = [];
                /** @var ConstraintViolationInterface $error */
                foreach ($errors as $error) {
                    $result[] = [
                        'field'   => $error->getPropertyPath(),
                        'message' => $error->getMessage(),
                    ];
                }
                
                return $result;
            }));
        } else {
            try {
                return new Response($this->finder->findByDate($request->getDate()));
            } catch (UnknownTemperatureHistoryException $unknownTemperatureHistoryException) {
                throw  new JsonRpcException(-32002, "Server error", ['message' => $unknownTemperatureHistoryException->getMessage()]);
            }
        }
    }
    
    
}
