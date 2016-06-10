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

namespace WellCommerce\Bundle\ProductBundle\Entity\Product;

use DateTime;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\IdentifiableEntityInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareInterface;
use WellCommerce\Bundle\ProductStatusBundle\Entity\ProductStatusInterface;

/**
 * Interface DistinctionInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DistinctionInterface extends IdentifiableEntityInterface, TimestampableInterface, ProductAwareInterface
{
    public function getValidFrom();

    public function setValidFrom(DateTime $validFrom = null);

    public function getValidTo();

    public function setValidTo(DateTime $validTo = null);

    public function setStatus(ProductStatusInterface $status);

    public function getStatus() : ProductStatusInterface;
}
