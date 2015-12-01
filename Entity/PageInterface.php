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
use WellCommerce\Bundle\ShopBundle\Entity\ShopCollectionAwareInterface;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;

/**
 * Interface PageInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PageInterface
    extends TranslatableInterface, TimestampableInterface, BlameableInterface, HierarchyAwareInterface, ShopCollectionAwareInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return bool
     */
    public function getPublish();

    /**
     * @param bool $publish
     */
    public function setPublish($publish);

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
    public function getChildren();

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
    public function getClientGroups();

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
}
