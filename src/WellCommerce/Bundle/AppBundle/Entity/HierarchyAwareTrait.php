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
 * Class HierarchyAwareTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait HierarchyAwareTrait
{
    /**
     * @var int
     */
    protected $hierarchy = 0;
    
    /**
     * @return int
     */
    public function getHierarchy(): int
    {
        return $this->hierarchy;
    }
    
    /**
     * @param int $hierarchy
     */
    public function setHierarchy(int $hierarchy)
    {
        $this->hierarchy = $hierarchy;
    }
}
