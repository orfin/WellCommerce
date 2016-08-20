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

namespace WellCommerce\Bundle\AppBundle\Factory;

use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\AppBundle\Entity\PriceInterface;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractEntityFactory;

/**
 * Class PriceFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class PriceFactory extends AbstractEntityFactory
{
    public function create() : PriceInterface
    {
        $price = new Price();
        $price->setGrossAmount(0);
        $price->setNetAmount(0);
        $price->setTaxAmount(0);
        $price->setTaxRate(0);
        $price->setCurrency('');
        
        return $price;
    }
}
