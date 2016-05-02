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
use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareTrait;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;

/**
 * Class Category
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminMenu extends AbstractEntity implements AdminMenuInterface
{
    use HierarchyAwareTrait;
    
    /**
     * @var string
     */
    protected $identifier;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $routeName;
    
    /**
     * @var string
     */
    protected $cssClass;
    
    /**
     * @var null|AdminMenuInterface
     */
    protected $parent;
    
    /**
     * @var Collection
     */
    protected $children;
    
    /**
     * {@inheritdoc}
     */
    public function getIdentifier() : string
    {
        return $this->identifier;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return $this->name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setParent(AdminMenuInterface $parent = null)
    {
        $this->parent = $parent;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setChildren(Collection $children)
    {
        $this->children = $children;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getChildren() : Collection
    {
        return $this->children;
    }
    
    /**
     * {@inheritdoc}
     */
    public function addChild(AdminMenuInterface $child)
    {
        $this->children[] = $child;
        $child->setParent($this);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getRouteName() : string
    {
        return $this->routeName;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setRouteName(string $routeName)
    {
        $this->routeName = $routeName;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCssClass() : string
    {
        return $this->cssClass;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCssClass(string $cssClass)
    {
        $this->cssClass = $cssClass;
    }
}
