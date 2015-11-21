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

namespace WellCommerce\CatalogBundle\Entity;

/**
 * Class ProducerAwareTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait ProducerAwareTrait
{
    /**
     * @var ProducerInterface
     */
    protected $producer;

    /**
     * @return ProducerInterface
     */
    public function getProducer()
    {
        return $this->producer;
    }

    /**
     * @param ProducerInterface $producer
     */
    public function setProducer(ProducerInterface $producer)
    {
        $this->producer = $producer;
    }
}
