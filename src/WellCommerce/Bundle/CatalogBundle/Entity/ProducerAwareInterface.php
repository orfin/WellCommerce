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

namespace WellCommerce\Bundle\CatalogBundle\Entity;

/**
 * Interface ProducerAwareInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProducerAwareInterface
{
    /**
     * @return ProducerInterface
     */
    public function getProducer();

    /**
     * @param ProducerInterface $producer
     */
    public function setProducer(ProducerInterface $producer);
}
