<?php
namespace Application\Service;

/*
 * Data de criação: 18/03/2018 12:33:08
 *
 * Desenvolvido por Guilherme Alves.
 */

class Customer
{

    private $configs;

    public function __construct($config)
    {
        $this->configs = $config['api'];
    }

    private function getHttpClient()
    {
        return new \Zend\Http\Client(null, array('adapter' => \Zend\Http\Client\Adapter\Socket::class));
    }

    public function getOrders($token)
    {
        $request = new \Zend\Http\Request();
        $request->setMethod(\Zend\Http\Request::METHOD_GET);
        $request->getHeaders()->addHeaders([
            'content-type' => 'application/json',
            'accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ]);

        $request->setUri($this->configs['endpoint'] . '/api/v1/Order/customer');
        $response = $this->getHttpClient()->send($request);

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException("Api error " . $response->getStatusCode() . " " . $response->getBody());
        }

        return json_decode($response->getBody());
    }
    
    public function doOrder($token, $param)
    {
        
    }
}
