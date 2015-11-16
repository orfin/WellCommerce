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

namespace WellCommerce\Bundle\CatalogBundle\Context\Front;

use WellCommerce\Bundle\CatalogBundle\Entity\ProducerInterface;

/**
 * Interface ProducerContextInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProducerContextInterface
{
    /**
     * @param ProducerInterface $producer
     */
    public function setCurrentProducer(ProducerInterface $producer);

    /**
     * @return null|ProducerInterface
     */
    public function getCurrentProducer();

    /**
     * @return int|null
     */
    public function getCurrentProducerIdentifier();

    /**
     * @return bool
     */
    public function hasCurrentProducer();
}
