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

namespace WellCommerce\Bundle\CmsBundle\Repository;

use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Repository\DataGridAwareRepositoryInterface;

/**
 * Interface PageRepositoryInterface
 *
 * @package WellCommerce\Bundle\CmsBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PageRepositoryInterface extends RepositoryInterface, DataGridAwareRepositoryInterface
{
    /**
     * Returns pages tree as a collection
     *
     * @return mixed
     */
    public function getTreeItems();

    /**
     * Returns parsed pages tree
     *
     * @return array
     */
    public function getPagesTree();
} 