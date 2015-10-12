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
use WellCommerce\Bundle\CoreBundle\Entity\HierarchyAwareTrait;

/**
 * Class Category
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminMenu implements AdminMenuInterface
{
    use HierarchyAwareTrait;

    /**
     * @var integer
     */
    protected $id;

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * {@inheritdoc}
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = (string)$identifier;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = (string)$name;
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
    public function getChildren()
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
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * {@inheritdoc}
     */
    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;
    }

    /**
     * {@inheritdoc}
     */
    public function getCssClass()
    {
        return $this->cssClass;
    }

    /**
     * {@inheritdoc}
     */
    public function setCssClass($cssClass)
    {
        $this->cssClass = $cssClass;
    }
}
