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

namespace WellCommerce\Bundle\ProductBundle\Repository;

use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Interface ProductAttributeRepositoryInterface
 *
 * @package WellCommerce\Bundle\ProductBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProductAttributeRepositoryInterface extends RepositoryInterface
{
    /**
     * Finds product attribute entity by its id or creates a new one
     *
     * @param $id
     * @param $data
     *
     * @return mixed
     */
    public function findOrCreate($id, $data);
}
