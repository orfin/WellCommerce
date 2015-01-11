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

namespace WellCommerce\Bundle\PaymentBundle\Processor;

/**
 * Class PaymentMethodProcessorCollection
 *
 * @package WellCommerce\Bundle\PaymentBundle\Processor
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
        $this->processors[$processor->getAlias()] = $processor;
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->processors;
    }

    /**
     * Returns processor by its alias
     *
     * @param $alias
     *
     * @return array
     * @throws \InvalidArgumentException If the processor was not found in collection
     */
    public function get($alias)
    {
        if (!$this->has($alias)) {
            throw new \InvalidArgumentException(sprintf('Payment method processor "%s" does not exists.', $alias));
        }

        return $this->processors;
    }

    /**
     * Checks whether collection contains such processor
     *
     * @param $alias
     *
     * @return bool
     */
    public function has($alias)
    {
        return isset($this->processors[$alias]);
    }
}
