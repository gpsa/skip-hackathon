<?php
/*
 * Data de criação: 18/03/2018 12:32:46
 *
 * Desenvolvido por Guilherme Alves.
 */
namespace ApplicationTest\Service;

use Application\Service\Customer;
use Zend\Stdlib\ArrayUtils;
use PHPUnit\Framework\TestCase;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\ServiceManager;

class CustomerTest extends TestCase
{

    /**
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected $serviceManager;

    /**
     * Set up LoggerAbstractServiceFactory and loggers configuration.
     *
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->serviceManager = new ServiceManager();
        $config = new Config([
            'services' => [
                'config' => [
                    'api' => [
                        'endpoint' => 'http://api-vanhack-event-sp.azurewebsites.net'
                    ]
                ],
            ],
        ]);
        $config->configureServiceManager($this->serviceManager);
    }

    private function getHttpClient()
    {
        return new \Zend\Http\Client(null, array('adapter' => \Zend\Http\Client\Adapter\Socket::class));
    }

    public function testLogin()
    {
        $config = $this->serviceManager->get('config');


        $params = array('email' => 'guilhermepsa@gmail.com', 'password' => '123456');

        $request = new \Zend\Http\Request();
        $request->setMethod(\Zend\Http\Request::METHOD_POST);
        $request->getPost()->fromArray($params);
        $request->getHeaders()->addHeaders([
//            'content-type' => 'application/json'
        ]);

        // $request->setContent($json);
        $request->setUri($config['api']['endpoint'] . '/api/v1/Customer/auth');
        $response = $this->getHttpClient()->send($request);

        $this->assertEquals(200, $response->getStatusCode());

        return $response->getBody();
    }

    /**
     * 
     * @param type $token
     * @depends testLogin
     */
    public function testOrderList($token)
    {
        $customer = new Customer($this->serviceManager->get('config'));
        
        $this->assertInternalType('array', $customer->getOrders($token));
    }
    
    /**
     * 
     * @param type $token
     * @depends testLogin
     */
    public function testMakeOrder()
    {
        $this->assertTrue(false);
    }
}
