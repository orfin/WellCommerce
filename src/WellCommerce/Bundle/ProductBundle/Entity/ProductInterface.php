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

namespace WellCommerce\Bundle\ProductBundle\Entity;

use WellCommerce\Bundle\AvailabilityBundle\Entity\AvailabilityAwareInterface;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;
use WellCommerce\Bundle\MultiStoreBundle\Entity\ShopCollectionAwareInterface;
use WellCommerce\Bundle\ProducerBundle\Entity\ProducerAwareInterface;
use WellCommerce\Bundle\UnitBundle\Entity\UnitAwareInterface;

/**
 * Interface ProductInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProductInterface extends
    TranslatableInterface,
    TimestampableInterface,
    BlameableInterface,
    ShopCollectionAwareInterface,
    ProducerAwareInterface,
    UnitAwareInterface,
    AvailabilityAwareInterface
{
    /**
     * @return int
     */
    public function getId();
}
