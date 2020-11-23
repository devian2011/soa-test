<?php

namespace App\Domain\Weather\Data\Providers\Service;

/**
 * Class JsonRpcResponse
 *
 * @package Domain\Weather\Data\Providers\Service
 */
class JsonRpcRequest implements \JsonSerializable
{
    private $id;
    /** @var string */
    private $method;
    /** @var array */
    private $params;
    
    /**
     * JsonRpcRequest constructor.
     *
     * @param string $method
     * @param array  $params
     */
    public function __construct(string $method, array $params)
    {
        $this->id = uniqid();
        $this->method = $method;
        $this->params = $params;
    }
    
    public function jsonSerialize()
    {
        return [
            'jsonrpc' => '2.0',
            'id'      => $this->id,
            'method'  => $this->method,
            'params'  => $this->params
        ];
    }
    
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
    
    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
    
    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
    
}
