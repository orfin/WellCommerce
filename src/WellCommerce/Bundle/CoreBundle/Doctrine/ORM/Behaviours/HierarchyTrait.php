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

namespace WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours;

/**
 * Class ActivatableTrait
 *
 * @package WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait HierarchyTrait
{
    /**
     * @ORM\Column(name="hierarchy", type="integer", nullable=true, options={"default":0})
     */
    private $hierarchy;

    public function getHierarchy()
    {
        return $this->hierarchy;
    }

    public function setHierarchy($hierarchy)
    {
        $this->hierarchy = $hierarchy;
    }
} 