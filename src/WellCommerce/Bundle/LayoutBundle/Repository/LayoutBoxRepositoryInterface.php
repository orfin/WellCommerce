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

use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Repository\DataGridAwareRepositoryInterface;

/**
 * Interface LayoutBoxRepositoryInterface
 *
 * @package WellCommerce\Bundle\LayoutBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LayoutBoxRepositoryInterface extends RepositoryInterface, DataGridAwareRepositoryInterface
{
    /**
     * Returns a collection of boxes
     *
     * @return \WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxCollection
     */
    public function getLayoutBoxesCollection();
} 