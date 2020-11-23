<?php

namespace App\Domain\Weather\Data\Providers\Service;

use App\Domain\Weather\Exceptions\InvalidRequestResponseAssociationException;

/**
 * Class JsonRpcResponse
 *
 * @package Domain\Weather\Data\Providers\Service
 */
class JsonRpcResponse
{
    /** @var JsonRpcRequest */
    private $request;
    
    /** @var array */
    private $output;
    
    /**
     * JsonRpcResponse constructor.
     *
     * @param JsonRpcRequest $request
     * @param array          $output
     *
     * @throws InvalidRequestResponseAssociationException
     */
    public function __construct(JsonRpcRequest $request, array $output)
    {
        $this->request = $request;
        $this->output = $output;
        if ($this->output['id'] !== $request->getId()) {
            throw new InvalidRequestResponseAssociationException("Request id: {$this->request->getId()}. Response id: {$this->output['id']}");
        }
    }
    
    /**
     * @return JsonRpcRequest
     */
    public function getRequest(): JsonRpcRequest
    {
        return $this->request;
    }
    
    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->output['result'];
    }
    
    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->output['error']);
    }
    
    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->output['error'];
    }
    
    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        if (isset($this->output['error']['data']) && isset($this->output['error']['data']['message'])) {
            return $this->output['error']['data']['message'];
        } else {
            return $this->output['error']['message'];
        }
    }
    
}
