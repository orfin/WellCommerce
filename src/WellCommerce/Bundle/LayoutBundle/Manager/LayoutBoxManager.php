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

namespace WellCommerce\Bundle\LayoutBundle\Layout;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class LayoutBoxManager
 *
 * @package WellCommerce\Bundle\LayoutBundle\Layout
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxManager
{
    protected $configurators = [];

    public function __construct(LayoutBoxConfiguratorCollection $collection)
    {
        $co = new ArrayCollection();

        $this->configurators = $collection;
    }

    public function getCollectionToSelect()
    {
//        $select = [];
//        foreach ($this->configurators->all() as $type => $configurator) {
//            $select[$type]
//        }
    }


} 