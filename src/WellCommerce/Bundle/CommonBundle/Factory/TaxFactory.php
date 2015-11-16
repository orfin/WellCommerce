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

namespace WellCommerce\Bundle\CommonBundle\Factory;

use WellCommerce\Bundle\CommonBundle\Entity\Tax;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;

/**
 * Class TaxFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\Bundle\CommonBundle\Entity\TaxInterface
     */
    public function create()
    {
        $tax = new Tax();
        $tax->setValue(0);
        $tax->setCreatedAt(new \DateTime());

        return $tax;
    }
}
