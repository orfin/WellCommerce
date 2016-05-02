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

namespace WellCommerce\Bundle\PageBundle\Entity;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareInterface;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\ShopBundle\Entity\ShopCollectionAwareInterface;

/**
 * Interface PageInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PageInterface extends
    EntityInterface,
    TranslatableInterface,
    TimestampableInterface,
    BlameableInterface,
    HierarchyAwareInterface,
    ShopCollectionAwareInterface
{
    /**
     * @return bool
     */
    public function getPublish() : bool;
    
    /**
     * @param bool $publish
     */
    public function setPublish(bool $publish);
    
    /**
     * @return null|PageInterface
     */
    public function getParent();
    
    /**
     * @param PageInterface|null $parent
     */
    public function setParent(PageInterface $parent = null);
    
    /**
     * @return Collection
     */
    public function getChildren() : Collection;
    
    /**
     * @param PageInterface $child
     */
    public function addChild(PageInterface $child);
    
    /**
     * @return string
     */
    public function getRedirectRoute();
    
    /**
     * @param string $redirectRoute
     */
    public function setRedirectRoute($redirectRoute);
    
    /**
     * @return string
     */
    public function getRedirectUrl();
    
    /**
     * @param string $redirectUrl
     */
    public function setRedirectUrl($redirectUrl);
    
    /**
     * @return Collection
     */
    public function getClientGroups() : Collection;
    
    /**
     * @param Collection $clientGroups
     */
    public function setClientGroups(Collection $clientGroups);
    
    /**
     * @return int
     */
    public function getRedirectType();
    
    /**
     * @param int $redirectType
     */
    public function setRedirectType($redirectType);
    
    /**
     * @return string
     */
    public function getSection() : string;
    
    /**
     * @param string $section
     */
    public function setSection(string $section);
}
