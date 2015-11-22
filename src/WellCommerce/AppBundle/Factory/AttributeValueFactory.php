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

namespace WellCommerce\AppBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\AppBundle\Entity\AttributeValue;
use WellCommerce\AppBundle\Factory\AbstractFactory;

/**
 * Class AttributeValueFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeValueFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\AppBundle\Entity\AttributeValueInterface
     */
    public function create()
    {
        $value = new AttributeValue();
        $value->setProductAttributeValues(new ArrayCollection());

        return $value;
    }
}
