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

namespace WellCommerce\Plugin\PaymentMethod\Configurator;

/**
 * Class PaymentMethodConfiguratorCollection
 *
 * @package WellCommerce\Plugin\PaymentMethod\Processor
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodConfiguratorCollection implements \IteratorAggregate, \Countable
{
    /**
     * @var array Collection of payment method configurators
     */
    protected $configurators = [];

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->configurators);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->configurators);
    }

    /**
     * {@inheritdoc}
     */
    public function add(PaymentMethodConfiguratorInterface $configurator)
    {
        $this->configurators[] = $configurator;
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->configurators;
    }
} 