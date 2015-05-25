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

namespace WellCommerce\Bundle\CoreBundle\Manager\Front;

use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;
use WellCommerce\Bundle\CoreBundle\Provider\ProviderCollection;
use WellCommerce\Bundle\MultiStoreBundle\Context\ShopContextInterface;

/**
 * Class AbstractFrontManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractFrontManager extends AbstractManager implements FrontManagerInterface
{
    /**
     * @var ProviderCollection
     */
    protected $providers;

    /**
     * @var ShopContextInterface
     */
    protected $shopContext;

    /**
     * {@inheritdoc}
     */
    public function setProviders(ProviderCollection $collection)
    {
        $this->providers = $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * {@inheritdoc}
     */
    public function getProvider($type)
    {
        return $this->providers->get($type);
    }

    /**
     * {@inheritdoc}
     */
    public function setShopContext(ShopContextInterface $shopContext)
    {
        $this->shopContext = $shopContext;
    }

    /**
     * @return ShopContextInterface
     */
    public function getShopContext()
    {
        return $this->shopContext;
    }
}
