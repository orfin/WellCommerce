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

namespace WellCommerce\Bundle\CmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\HierarchyTrait;
use WellCommerce\Bundle\MultiStoreBundle\Entity\Shop;

/**
 * Class Page
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table(name="page")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\CmsBundle\Repository\PageRepository")
 */
class Page
{
    use ORMBehaviors\Translatable\Translatable;
    use ORMBehaviors\Timestampable\Timestampable;
    use ORMBehaviors\Blameable\Blameable;
    use HierarchyTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="publish", type="boolean", options={"default" = 0})
     *
     */
    private $publish;

    /**
     * @ORM\Column(name="redirect_type", type="integer", options={"default" = 0})
     *
     */
    private $redirectType;

    /**
     * @ORM\Column(name="redirect_url", type="string", length=255, nullable=true)
     *
     */
    private $redirectUrl;

    /**
     * @ORM\Column(name="redirect_route", type="string", length=255, nullable=true)
     *
     */
    private $redirectRoute;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\CmsBundle\Entity\Page", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="WellCommerce\Bundle\CmsBundle\Entity\Page", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\MultiStoreBundle\Entity\Shop", inversedBy="pages")
     * @ORM\JoinTable(name="shop_page",
     *      joinColumns={@ORM\JoinColumn(name="page_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="shop_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $shops;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->shops    = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPublish()
    {
        return $this->publish;
    }

    /**
     * @param mixed $publish
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;
    }

    /**
     * Returns page parent
     *
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Sets page parent
     *
     * @param null|Page $parent
     */
    public function setParent(Page $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * Returns page children
     *
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Adds new child to page
     *
     * @param Page $child
     */
    public function addChild(Page $child)
    {
        $this->children[] = $child;
        $child->setParent($this);
    }

    /**
     * @return mixed
     */
    public function getShops()
    {
        return $this->shops;
    }

    /**
     * @param Shop $shop
     */
    public function addShop(Shop $shop)
    {
        $this->shops[] = $shop;
    }

    /**
     * @param mixed $shops
     */
    public function setShops($shops)
    {
        $this->shops = $shops;
    }

    /**
     * @return mixed
     */
    public function getRedirectRoute()
    {
        return $this->redirectRoute;
    }

    /**
     * @param mixed $redirectRoute
     */
    public function setRedirectRoute($redirectRoute)
    {
        $this->redirectRoute = $redirectRoute;
    }

    /**
     * @return mixed
     */
    public function getRedirectType()
    {
        return $this->redirectType;
    }

    /**
     * @param mixed $redirectType
     */
    public function setRedirectType($redirectType)
    {
        $this->redirectType = $redirectType;
    }

    /**
     * @return mixed
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * @param mixed $redirectUrl
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
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
}
