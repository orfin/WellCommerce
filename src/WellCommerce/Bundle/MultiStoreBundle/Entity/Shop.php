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

use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatusInterface;
use WellCommerce\Bundle\ThemeBundle\Entity\ThemeInterface;

/**
 * Class Shop
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Shop implements ShopInterface
{
    use Timestampable, Blameable;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var CompanyInterface
     */
    protected $company;

    /**
     * @var Collection
     */
    protected $products;

    /**
     * @var Collection
     */
    protected $categories;

    /**
     * @var Collection
     */
    protected $producers;

    /**
     * @var Collection
     */
    protected $pages;

    /**
     * @var ThemeInterface
     */
    protected $theme;

    /**
     * @var OrderStatusInterface
     */
    protected $defaultOrderStatus;

    /**
     * @var string
     */
    protected $defaultCountry;

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
     * @return Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     */
    public function setProducts(Collection $products)
    {
        $this->products = $products;
    }

    /**
     * @return CompanyInterface
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param CompanyInterface $company
     */
    public function setCompany(CompanyInterface $company)
    {
        $this->company = $company;
    }

    /**
     * @return Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param Collection $categories
     */
    public function setCategories(Collection $categories)
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
    public function setProducers(Collection $producers)
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
     * @param ThemeInterface $theme
     */
    public function setTheme(ThemeInterface $theme)
    {
        $this->theme = $theme;
    }

    /**
     * @return Collection
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param Collection $pages
     */
    public function setPages(Collection $pages)
    {
        $this->pages = $pages;
    }

    /**
     * @return OrderStatusInterface
     */
    public function getDefaultOrderStatus()
    {
        return $this->defaultOrderStatus;
    }

    /**
     * @param OrderStatusInterface $defaultOrderStatus
     */
    public function setDefaultOrderStatus(OrderStatusInterface $defaultOrderStatus)
    {
        $this->defaultOrderStatus = $defaultOrderStatus;
    }

    /**
     * @return string
     */
    public function getDefaultCountry()
    {
        return $this->defaultCountry;
    }

    /**
     * @param string $defaultCountry
     */
    public function setDefaultCountry($defaultCountry)
    {
        $this->defaultCountry = $defaultCountry;
    }
}
