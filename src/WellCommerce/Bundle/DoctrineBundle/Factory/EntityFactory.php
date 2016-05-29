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

namespace WellCommerce\Bundle\DoctrineBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\AppBundle\Entity\DiscountablePriceInterface;
use WellCommerce\Bundle\AppBundle\Entity\PriceInterface;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\CurrencyBundle\Entity\CurrencyInterface;
use WellCommerce\Bundle\ShopBundle\Entity\ShopInterface;
use WellCommerce\Bundle\TaxBundle\Entity\TaxInterface;

/**
 * Class EntityFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class EntityFactory extends AbstractContainerAware implements EntityFactoryInterface
{
    /**
     * @var string
     */
    private $className;

    /**
     * EntityFactory constructor.
     *
     * @param string $className
     */
    public function __construct(string $className)
    {
        $this->className = $className;
    }

    public function create()
    {
        return $this->init();
    }
    
    protected function init()
    {
        return new $this->className;
    }

    protected function createDiscountablePrice() : DiscountablePriceInterface
    {
        return $this->get('discountable_price.factory')->create();
    }
    
    protected function createPrice() : PriceInterface
    {
        return $this->get('price.factory')->create();
    }
    
    protected function getDefaultCurrency() : CurrencyInterface
    {
        return $this->get('currency.repository')->findOneBy([]);
    }
    
    protected function getDefaultTax() : TaxInterface
    {
        return $this->get('tax.repository')->findOneBy([]);
    }
    
    protected function getDefaultShops() : Collection
    {
        return $this->get('shop.repository')->matching(new Criteria());
    }
    
    protected function getDefaultShop() : ShopInterface
    {
        return $this->get('shop.storage')->getCurrentShop();
    }
    
    protected function createEmptyCollection() : Collection
    {
        return new ArrayCollection();
    }
}
