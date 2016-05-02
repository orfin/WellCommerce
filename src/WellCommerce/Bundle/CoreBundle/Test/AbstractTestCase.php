<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 * 
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 * 
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\CoreBundle\Test;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class AbstractTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractTestCase extends KernelTestCase
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    protected $client = null;
    
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;
    
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    
    /**
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    protected $validator;
    
    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $this->client    = static::createClient();
        $this->container = $this->client->getContainer();
        $this->em        = $this->container->get('doctrine')->getManager();
        $this->validator = $this->container->get('validator');
        $this->setCurrentShop();
    }
    
    /**
     * Creates a Client.
     *
     * @param array $options An array of options to pass to the createKernel class
     * @param array $server  An array of server parameters
     *
     * @return Client A Client instance
     */
    protected static function createClient(array $options = [], array $server = [])
    {
        static::bootKernel($options);
        
        $client = static::$kernel->getContainer()->get('test.client');
        $client->setServerParameters($server);
        
        return $client;
    }
    
    private function setCurrentShop()
    {
        $shop = $this->container->get('shop.repository')->findOneBy([]);
        $this->container->get('shop.context.admin')->setCurrentShop($shop);
    }
}
