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
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareTrait;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;
use WellCommerce\Bundle\ShopBundle\Entity\ShopCollectionAwareTrait;

/**
 * Class Page
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Page extends AbstractEntity implements PageInterface
{
    use Translatable;
    use Timestampable;
    use Blameable;
    use HierarchyAwareTrait;
    use ShopCollectionAwareTrait;
    
    /**
     * @var bool
     */
    protected $publish;
    
    /**
     * @var int
     */
    protected $redirectType;
    
    /**
     * @var string
     */
    protected $section;
    
    /**
     * @var string
     */
    protected $redirectUrl;
    
    /**
     * @var string
     */
    protected $redirectRoute;
    
    /**
     * @var PageInterface|null
     */
    protected $parent;
    
    /**
     * @var Collection
     */
    protected $clientGroups;
    
    /**
     * @var Collection
     */
    protected $children;
    
    /**
     * {@inheritdoc}
     */
    public function getPublish() : bool
    {
        return $this->publish;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPublish(bool $publish)
    {
        $this->publish = $publish;
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
    public function setParent(PageInterface $parent = null)
    {
        $this->parent = $parent;
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
    public function addChild(PageInterface $child)
    {
        $this->children[] = $child;
        $child->setParent($this);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getRedirectRoute()
    {
        return $this->redirectRoute;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setRedirectRoute($redirectRoute)
    {
        $this->redirectRoute = $redirectRoute;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getClientGroups() : Collection
    {
        return $this->clientGroups;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setClientGroups(Collection $clientGroups)
    {
        $this->clientGroups = $clientGroups;
    }
    
    /**
     * {@inheritdoc}
     */
    public function prePersist()
    {
        $redirectType = $this->getRedirectType();
        switch ($redirectType) {
            case 0:
                $this->setRedirectRoute(null);
                $this->setRedirectUrl(null);
                break;
            case 1:
                $this->setRedirectRoute(null);
                break;
            case 2:
                $this->setRedirectUrl(null);
                break;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function getRedirectType()
    {
        return $this->redirectType;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setRedirectType($redirectType)
    {
        $this->redirectType = $redirectType;
    }
    
    /**
     * @return string
     */
    public function getSection() : string
    {
        return $this->section;
    }
    
    /**
     * @param string $section
     */
    public function setSection(string $section)
    {
        $this->section = $section;
    }
}
