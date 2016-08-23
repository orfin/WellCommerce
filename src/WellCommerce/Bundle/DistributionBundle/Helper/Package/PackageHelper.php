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

namespace WellCommerce\Bundle\DistributionBundle\Helper\Package;

use Packagist\Api\Client;

/**
 * Class PackageHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PackageHelper implements PackageHelperInterface
{
    /**
     * @var Client
     */
    protected $client;
    
    /**
     * Constructor
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPackages(array $criteria)
    {
        $this->client->setPackagistUrl(self::PACKAGIST_URL);
        
        return $this->client->all($criteria);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPackage($name)
    {
        return $this->client->get($name);
    }
}
