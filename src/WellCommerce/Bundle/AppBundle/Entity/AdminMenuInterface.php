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

use Doctrine\Common\Collections\Collection;

/**
 * Interface AdminMenuInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AdminMenuInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return int
     */
    public function getHierarchy();

    /**
     * @param $hierarchy
     */
    public function setHierarchy($hierarchy);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getIdentifier();

    /**
     * @param string $identifier
     */
    public function setIdentifier($identifier);

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
    public function getChildren();

    /**
     * @param AdminMenuInterface $child
     */
    public function addChild(AdminMenuInterface $child);

    /**
     * @return string
     */
    public function getRouteName();

    /**
     * @param string $link
     */
    public function setRouteName($routeName);

    /**
     * @return string
     */
    public function getCssClass();

    /**
     * @param string $cssClass
     */
    public function setCssClass($cssClass);
}
