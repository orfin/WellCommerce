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

namespace WellCommerce\Bundle\AppBundle\Entity;

/**
 * Interface HierarchyAwareInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface HierarchyAwareInterface
{
    public function setHierarchy(int $hierarchy);
    
    public function getHierarchy() : int;
}
