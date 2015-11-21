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

namespace WellCommerce\CatalogBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\CatalogBundle\Entity\Attribute;
use WellCommerce\CoreBundle\Factory\AbstractFactory;

/**
 * Class AttributeFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\CatalogBundle\Entity\AttributeInterface
     */
    public function create()
    {
        $attribute = new Attribute();
        $attribute->setValues(new ArrayCollection());

        return $attribute;
    }
}
