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

namespace WellCommerce\CatalogBundle\Repository;

use WellCommerce\CatalogBundle\Entity\AttributeInterface;
use WellCommerce\AppBundle\Repository\RepositoryInterface;

/**
 * Interface AttributeValueRepositoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AttributeValueRepositoryInterface extends RepositoryInterface
{
    /**
     * Returns all attributes values
     *
     * @param AttributeInterface $attribute
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCollectionByAttribute(AttributeInterface $attribute);
}
