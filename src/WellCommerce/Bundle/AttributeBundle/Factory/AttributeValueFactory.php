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

namespace WellCommerce\Bundle\AttributeBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeValueInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class AttributeValueFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeValueFactory extends AbstractEntityFactory
{
    public function create() : AttributeValueInterface
    {
        /** @var $value AttributeValueInterface */
        $value = $this->init();
        $value->setAttributes($this->createEmptyCollection());

        return $value;
    }
}
