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

namespace WellCommerce\Bundle\TaxBundle\Factory;

use WellCommerce\Bundle\CoreBundle\Factory\FactoryInterface;

/**
 * Class TaxFactoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface TaxFactoryInterface extends FactoryInterface
{
    /**
     * @return \WellCommerce\Bundle\TaxBundle\Entity\TaxInterface
     */
    public function create();
}
