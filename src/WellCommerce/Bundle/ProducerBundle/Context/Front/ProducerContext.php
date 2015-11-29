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

namespace WellCommerce\Bundle\AppBundle\Context\Front;

use WellCommerce\Bundle\AppBundle\Entity\ProducerInterface;

/**
 * Class ProducerContext
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerContext implements ProducerContextInterface
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
    public function getCurrentProducer()
    {
        return $this->currentProducer;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentProducerIdentifier()
    {
        if ($this->hasCurrentProducer()) {
            return $this->currentProducer->getId();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function hasCurrentProducer()
    {
        return $this->currentProducer instanceof ProducerInterface;
    }

}
