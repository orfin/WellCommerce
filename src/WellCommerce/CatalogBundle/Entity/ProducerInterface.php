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

use Doctrine\Common\Collections\Collection;
use WellCommerce\CommonBundle\Entity\ShopCollectionAwareInterface;
use WellCommerce\AppBundle\Entity\BlameableInterface;
use WellCommerce\AppBundle\Entity\TimestampableInterface;
use WellCommerce\AppBundle\Entity\TranslatableInterface;

/**
 * Interface ProducerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProducerInterface extends TranslatableInterface, TimestampableInterface, BlameableInterface, ShopCollectionAwareInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @return Collection|\WellCommerce\CatalogBundle\Entity\ProductInterface[]
     */
    public function getProducts();

    /**
     * @return Collection|\WellCommerce\CatalogBundle\Entity\DelivererInterface[]
     */
    public function getDeliverers();

    /**
     * @param Collection $collection
     */
    public function setDeliverers(Collection $collection);

    /**
     * @param DelivererInterface $deliverer
     */
    public function addDeliverer(DelivererInterface $deliverer);
}
