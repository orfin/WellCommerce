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

namespace WellCommerce\Bundle\AdminBundle\Entity;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;

/**
 * Interface AdminMenuInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AdminMenuInterface extends EntityInterface, HierarchyAwareInterface
{
    /**
     * @return string
     */
    public function getName() : string;
    
    /**
     * @param string $name
     */
    public function setName(string $name);
    
    /**
     * @return string
     */
    public function getIdentifier() : string;
    
    /**
     * @param string $identifier
     */
    public function setIdentifier(string $identifier);
    
    /**
     * @return AdminMenuInterface|null
     */
    public function getParent();
    
    /**
     * @param AdminMenuInterface|null $parent
     */
    public function setParent(AdminMenuInterface $parent = null);
    
    /**
     * @param Collection $children
     */
    public function setChildren(Collection $children);
    
    /**
     * @return Collection|AdminMenuInterface[]
     */
    public function getChildren() : Collection;
    
    /**
     * @param AdminMenuInterface $child
     */
    public function addChild(AdminMenuInterface $child);
    
    /**
     * @return string
     */
    public function getRouteName() : string;
    
    /**
     * @param string $routeName
     */
    public function setRouteName(string $routeName);
    
    /**
     * @return string
     */
    public function getCssClass() : string;
    
    /**
     * @param string $cssClass
     */
    public function setCssClass(string $cssClass);
}
