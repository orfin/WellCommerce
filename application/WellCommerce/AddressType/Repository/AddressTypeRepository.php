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

namespace WellCommerce\AddressType\Repository;

/**
 * Class AddressTypeRepository
 *
 * @package WellCommerce\AddressType\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AddressTypeRepository implements R
{

    public function all()
    {
        $this->get('address_type.model')->all();
    }

} 