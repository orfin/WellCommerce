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

namespace WellCommerce\Bundle\ProducerBundle\Storage;

use WellCommerce\Bundle\ProducerBundle\Entity\ProducerInterface;

/**
 * Class ProducerStorage
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerStorage implements ProducerStorageInterface
{
    /**
     * @var ProducerInterface
     */
    protected $currentProducer;

    /**
     * {@inheritdoc}
     */
    public function setCurrentProducer(ProducerInterface $producer)
    {
        $this->currentProducer = $producer;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentProducer() : ProducerInterface
    {
        return $this->currentProducer;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentProducerIdentifier() : int
    {
        return $this->getCurrentProducer()->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function hasCurrentProducer() : bool
    {
        return $this->currentProducer instanceof ProducerInterface;
    }

}
