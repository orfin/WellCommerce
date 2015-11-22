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
use WellCommerce\CatalogBundle\Entity\Attribute\Group;
use WellCommerce\AppBundle\Factory\AbstractFactory;

/**
 * Class AttributeGroupFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeGroupFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\CatalogBundle\Entity\Attribute\GroupInterface
     */
    public function create()
    {
        $group = new Group();
        $group->setAttributes(new ArrayCollection());

        return $group;
    }
}
