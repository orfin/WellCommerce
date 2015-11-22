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

namespace WellCommerce\AppBundle\Collector;

use WellCommerce\AppBundle\Helper\CurrencyHelperInterface;
use WellCommerce\AppBundle\Factory\OrderTotalDetailFactory;

/**
 * Class AbstractDataCollector
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataCollector implements OrderDataCollectorInterface
{
    /**
     * @var OrderTotalDetailFactory
     */
    protected $factory;

    /**
     * @var CurrencyHelperInterface
     */
    protected $currencyHelper;

    /**
     * Constructor
     *
     * @param OrderTotalDetailFactory $factory
     */
    public function __construct(OrderTotalDetailFactory $factory, CurrencyHelperInterface $currencyHelper)
    {
        $this->factory        = $factory;
        $this->currencyHelper = $currencyHelper;
    }

    abstract public function getAlias();

    abstract public function getPriority();

    abstract public function getDescription();

    /**
     * @return \WellCommerce\AppBundle\Entity\OrderTotalDetailInterface
     */
    protected function initResource()
    {
        $resource = $this->factory->create();
        $resource->setCollector($this->getAlias());
        $resource->setHierarchy($this->getPriority());

        return $resource;
    }


}
