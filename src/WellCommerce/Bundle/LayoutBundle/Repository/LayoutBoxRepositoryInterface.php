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

namespace WellCommerce\Bundle\LayoutBundle\Repository;

use WellCommerce\Bundle\DoctrineBundle\Repository\RepositoryInterface;

/**
 * Interface LayoutBoxRepositoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LayoutBoxRepositoryInterface extends RepositoryInterface
{
    /**
     * Returns boxes collection
     *
     * @return \WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxCollection
     */
    public function getLayoutBoxesCollection();
}
