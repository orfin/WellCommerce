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

namespace WellCommerce\PaymentMethod\Processor;

/**
 * Class PaymentMethodProcessorCollection
 *
 * @package WellCommerce\PaymentMethod\Processor
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodProcessorCollection implements \IteratorAggregate, \Countable
{
    /**
     * @var array Collection of payment method processors
     */
    protected $processors = [];

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->processors);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->processors);
    }

    /**
     * {@inheritdoc}
     */
    public function add(PaymentMethodProcessorInterface $processor)
    {
        $this->processors[] = $processor;
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->processors;
    }
} 