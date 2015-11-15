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

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;
use WellCommerce\Bundle\CatalogBundle\Entity\ProducerInterface;

/**
 * Interface DelivererInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DelivererInterface extends TranslatableInterface, TimestampableInterface, BlameableInterface
{
    /**
     *
     * @return int
     */
    public function getId();

    /**
     * @return Collection
     */
    public function getProducers();

    /**
     * @param Collection $collection
     */
    public function setProducers(Collection $collection);

    /**
     * @param ProducerInterface $producer
     */
    public function addProducer(ProducerInterface $producer);
}
