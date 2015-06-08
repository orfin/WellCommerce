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

namespace WellCommerce\Bundle\MultiStoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatus;

/**
 * Class Shop
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\MultiStoreBundle\Repository\ShopRepository")
 */
class Shop
{
    use ORMBehaviors\Timestampable\Timestampable;
    use ORMBehaviors\Blameable\Blameable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    protected $url;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\MultiStoreBundle\Entity\Company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $company;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\ProductBundle\Entity\Product", mappedBy="shops")
     */
    protected $products;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\CategoryBundle\Entity\Category", mappedBy="shops")
     */
    protected $categories;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\ProducerBundle\Entity\Producer", mappedBy="shops")
     */
    protected $producers;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\CmsBundle\Entity\Page", mappedBy="shops")
     */
    protected $pages;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\ThemeBundle\Entity\Theme")
     * @ORM\JoinColumn(name="theme_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $theme;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\OrderBundle\Entity\OrderStatus")
     * @ORM\JoinColumn(name="default_order_status_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $defaultOrderStatus;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param ArrayCollection $categories
     */
    public function setCategories(ArrayCollection $categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return mixed
     */
    public function getProducers()
    {
        return $this->producers;
    }

    /**
     * @param mixed $producers
     */
    public function setProducers($producers)
    {
        $this->producers = $producers;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param mixed $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    /**
     * @return mixed
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param mixed $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    }

    /**
     * @return OrderStatus
     */
    public function getDefaultOrderStatus()
    {
        return $this->defaultOrderStatus;
    }

    /**
     * @param OrderStatus $defaultOrderStatus
     */
    public function setDefaultOrderStatus(OrderStatus $defaultOrderStatus)
    {
        $this->defaultOrderStatus = $defaultOrderStatus;
    }
}
