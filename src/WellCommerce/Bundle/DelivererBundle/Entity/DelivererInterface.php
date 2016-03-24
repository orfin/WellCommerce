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

namespace WellCommerce\Bundle\DelivererBundle\Entity;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\ProducerBundle\Entity\ProducerInterface;

/**
 * Interface DelivererInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DelivererInterface extends EntityInterface, TranslatableInterface, TimestampableInterface, BlameableInterface
{
    /**
     * @return Collection
     */
    public function getProducers() : Collection;

    /**
     * @param Collection $collection
     */
    public function setProducers(Collection $collection);

    /**
     * @param ProducerInterface $producer
     */
    public function addProducer(ProducerInterface $producer);
}
