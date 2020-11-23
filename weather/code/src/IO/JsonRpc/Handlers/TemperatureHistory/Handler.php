<?php

namespace App\IO\JsonRpc\Handlers\TemperatureHistory;

use App\Repository\UnknownTemperatureHistoryException;
use App\Services\Temperature\TemperatureHistoryGetter;
use IO\JsonRpc\Exception\WrongResponseBuilderInputDataException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Yoanm\JsonRpcServer\Domain\Exception\JsonRpcException;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;

class Handler implements JsonRpcMethodInterface
{
    
    /** @var TemperatureHistoryGetter */
    private $finder;
    
    /** @var ValidatorInterface */
    private $validator;
    
    /** @var LoggerInterface */
    private $logger;
    
    /**
     * Handler constructor.
     *
     * @param TemperatureHistoryGetter $historyGetter
     * @param ValidatorInterface       $validator
     * @param LoggerInterface          $logger
     */
    public function __construct(TemperatureHistoryGetter $historyGetter, ValidatorInterface $validator, LoggerInterface $logger)
    {
        $this->finder = $historyGetter;
        $this->validator = $validator;
        $this->logger = $logger;
    }
    
    /**
     * @param array|null $paramList
     *
     * @return Response|mixed
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
                return new Response($this->finder->findHistoryLimitedList($request->getLimit()));
            } catch (WrongResponseBuilderInputDataException $wrongResponseBuilderInputDataException) {
                $this->logger->error($wrongResponseBuilderInputDataException->getMessage(), ['exception' => $wrongResponseBuilderInputDataException]);
                throw new JsonRpcException(-32001, "Internal Server Error", ['message' => 'Internal server error']);
            }
        }
    }
    
    
}
