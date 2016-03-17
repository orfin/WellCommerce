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

namespace WellCommerce\Bundle\ProducerBundle\Context\Front;

use WellCommerce\Bundle\ProducerBundle\Entity\ProducerInterface;

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
     * @return ProducerInterface
     */
    public function getCurrentProducer() : ProducerInterface;

    /**
     * @return int
     */
    public function getCurrentProducerIdentifier() : int;

    /**
     * @return bool
     */
    public function hasCurrentProducer() : bool;
}
