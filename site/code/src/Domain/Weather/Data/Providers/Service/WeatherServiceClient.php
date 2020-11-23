<?php

namespace App\Domain\Weather\Data\Providers\Service;

use App\Domain\Weather\Data\Providers\Service\JsonRpcRequest;
use App\Domain\Weather\Data\Providers\Service\JsonRpcResponse;
use App\Domain\Weather\Exceptions\InvalidRequestResponseAssociationException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;
use App\Domain\Weather\Exceptions\WeatherServiceUnavailableException;

/**
 * Class WeatherServiceClient
 *
 * Здесь ещё можно ретраи добавить и целый пакет плюшек, но тогда это будет полноценный пакет =)
 *
 * @package App\Domain\Weather\Data\Providers\Service
 */
class WeatherServiceClient
{
    /** @var Client */
    private $client;
    /** @var string */
    private $endpoint;
    /** @var string */
    private $header;
    /** @var string */
    private $token;
    
    /**
     * WeatherServiceClient constructor.
     *
     * @param string $endpoint
     * @param string $header
     * @param string $token
     */
    public function __construct(string $endpoint, string $header, string $token)
    {
        $this->client = new Client([
            'timeout'         => 0,
            'allow_redirects' => true
        ]);
        $this->endpoint = $endpoint;
        $this->header = $header;
        $this->token = $token;
    }
    
    /**
     * @param string $method
     * @param array  $params
     *
     * @return JsonRpcResponse
     * @throws InvalidRequestResponseAssociationException
     * @throws WeatherServiceUnavailableException
     */
    public function sendRequest(string $method, array $params)
    {
        $jsonRpcRequest = new JsonRpcRequest($method, $params);
        $request = new Request("POST", $this->endpoint, [$this->header => $this->token],
            json_encode($jsonRpcRequest));
        try {
            $response = $this->client->send($request);
            if ($response->getStatusCode() !== 200) {
                throw new WeatherServiceUnavailableException();
            }
            return new JsonRpcResponse($jsonRpcRequest, json_decode($response->getBody()->getContents(), true));
            
        } catch (GuzzleException $exception) {
            throw new WeatherServiceUnavailableException($exception->getMessage());
        }
    }
    
}
