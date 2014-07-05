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

namespace WellCommerce\Plugin\AddressType\Repository;

/**
 * Interface AddressTypeRepositoryInterface
 *
 * @package WellCommerce\Plugin\AddressType\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AddressTypeRepositoryInterface
{
    /**
     * Returns all adress types as a collection
     *
     * @return mixed
     */
    public function all();

} 