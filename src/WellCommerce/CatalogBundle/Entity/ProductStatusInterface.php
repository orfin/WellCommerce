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
use WellCommerce\AppBundle\Entity\BlameableInterface;
use WellCommerce\AppBundle\Entity\TimestampableInterface;
use WellCommerce\AppBundle\Entity\TranslatableInterface;

/**
 * Interface ProductStatusInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProductStatusInterface extends TimestampableInterface, TranslatableInterface, BlameableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return Collection
     */
    public function getProducts();

    /**
     * @param Collection $collection
     */
    public function setProducts(Collection $collection);
}
