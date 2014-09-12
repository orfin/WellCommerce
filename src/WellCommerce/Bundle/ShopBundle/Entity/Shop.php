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

namespace WellCommerce\Bundle\ShopBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use WellCommerce\Bundle\CategoryBundle\Entity\Category;
use WellCommerce\Bundle\CoreBundle\Entity\Behaviours\MetaDataTrait;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutTheme;
use WellCommerce\Bundle\LocaleBundle\Entity\Locale;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethod;
use WellCommerce\Bundle\ProducerBundle\Entity\Producer;
use WellCommerce\Bundle\ProductBundle\Entity\Product;

/**
 * Class Shop
 *
 * @package WellCommerce\Bundle\ShopBundle\Entity
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table("shop")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\ShopBundle\Repository\ShopRepository")
 */
class Shop
{
    use ORMBehaviors\Timestampable\Timestampable;
    use ORMBehaviors\Blameable\Blameable;
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\CompanyBundle\Entity\Company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $company;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\CategoryBundle\Entity\Category", mappedBy="shops")
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\ProductBundle\Entity\Product", mappedBy="shops")
     */
    private $products;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethod", mappedBy="shops", cascade={"persist","remove"})
     */
    private $paymentMethods;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\ProducerBundle\Entity\Producer", mappedBy="shops")
     */
    private $producers;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\LocaleBundle\Entity\Locale", inversedBy="shops")
     * @ORM\JoinTable(name="shop_locale",
     *      joinColumns={@ORM\JoinColumn(name="shop_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="locale_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $availableLocales;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\LayoutBundle\Entity\LayoutTheme")
     * @ORM\JoinColumn(name="layout_theme_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $layoutTheme;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories       = new ArrayCollection();
        $this->products         = new ArrayCollection();
        $this->producers        = new ArrayCollection();
        $this->availableLocales = new ArrayCollection();
        $this->paymentMethods   = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns default shop theme
     *
     * @return mixed
     */
    public function getLayoutTheme()
    {
        return $this->layoutTheme;
    }

    /**
     * Sets default shop theme
     *
     * @param LayoutTheme $layoutTheme
     */
    public function setLayoutTheme(LayoutTheme $layoutTheme = null)
    {
        $this->layoutTheme = $layoutTheme;
    }

    /**
     * Get company.
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set company.
     *
     * @return string
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * Returns shop categories
     *
     * @return ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Adds new category to shop
     *
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        $this->categories[] = $category;
    }

    /**
     * Returns shop products
     *
     * @return ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Adds new product to shop
     *
     * @param Category $category
     */
    public function addProduct(Product $product)
    {
        $this->products[] = $product;
    }

    /**
     * Returns shop producers
     *
     * @return ArrayCollection
     */
    public function getProducers()
    {
        return $this->producers;
    }

    /**
     * Adds new category to shop
     *
     * @param Producer $producer
     */
    public function addProducer(Producer $producer)
    {
        $this->producers[] = $producer;
    }

    /**
     * Returns all available locales for shop entity
     *
     * @return ArrayCollection
     */
    public function getAvailableLocales()
    {
        return $this->availableLocales;
    }

    /**
     * Adds new locale for shop
     *
     * @param Locale $locale
     */
    public function addAvailableLocale(Locale $locale)
    {
        $this->availableLocales = $locale;
    }

    /**
     * Sets available locales
     *
     * @param ArrayCollection $collection
     */
    public function setAvailableLocales(ArrayCollection $collection)
    {
        $this->availableLocales = $collection;
    }

    /**
     * Returns all available payment methods
     *
     * @return ArrayCollection
     */
    public function getPaymentMethods()
    {
        return $this->paymentMethods;
    }

    /**
     * Adds new payment method to shop
     *
     * @param PaymentMethod $paymentMethod
     */
    public function addPaymentMethod(PaymentMethod $paymentMethod)
    {
        $this->paymentMethods = $paymentMethod;
    }

    /**
     * Sets available payment methods
     *
     * @param ArrayCollection $paymentMethods
     */
    public function setPaymentMethods(ArrayCollection $paymentMethods)
    {
        /**
         * First delete shop binding for not submitted payment methods
         *
         * @var $paymentMethod \WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethod
         */
        foreach ($this->paymentMethods as $paymentMethod) {
            if (!$paymentMethods->contains($paymentMethod)) {
                $paymentMethod->removeShop($this);
            }
        }

        /**
         * Add shop binding to passed methods
         *
         * @var $paymentMethod \WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethod
         */
        foreach ($paymentMethods as $paymentMethod) {
            $paymentMethod->addShop($this);
        }
    }
}

