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
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeValue;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeValueInterface;

/**
 * Class AttributeValueFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeValueFactory extends AbstractFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = AttributeValueInterface::class;

    /**
     * @return AttributeValueInterface
     */
    public function create()
    {
        /** @var $value AttributeValueInterface */
        $value = $this->init();
        $value->setProductAttributeValues(new ArrayCollection());

        return $value;
    }
}
