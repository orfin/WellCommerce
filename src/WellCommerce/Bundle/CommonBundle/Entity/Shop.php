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

namespace WellCommerce\Bundle\CommonBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\CoreBundle\Entity\MailerConfiguration;
use WellCommerce\Bundle\LayoutBundle\Entity\ThemeAwareTrait;

/**
 * Class Shop
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Shop implements ShopInterface
{
    use Timestampable;
    use Blameable;
    use ThemeAwareTrait;

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
     * @var string
     */
    protected $defaultCountry;

    /**
     * @var string
     */
    protected $defaultCurrency;

    /**
     * @var MailerConfiguration
     */
    protected $mailerConfiguration;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * {@inheritdoc}
     */
    public function setProducts(Collection $products)
    {
        $this->products = $products;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * {@inheritdoc}
     */
    public function setCompany(CompanyInterface $company)
    {
        $this->company = $company;
    }

    /**
     * {@inheritdoc}
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * {@inheritdoc}
     */
    public function setCategories(Collection $categories)
    {
        $this->categories = $categories;
    }

    /**
     * {@inheritdoc}
     */
    public function getProducers()
    {
        return $this->producers;
    }

    /**
     * {@inheritdoc}
     */
    public function setProducers(Collection $producers)
    {
        $this->producers = $producers;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * {@inheritdoc}
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * {@inheritdoc}
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * {@inheritdoc}
     */
    public function setPages(Collection $pages)
    {
        $this->pages = $pages;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultCountry()
    {
        return $this->defaultCountry;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultCountry($defaultCountry)
    {
        $this->defaultCountry = $defaultCountry;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultCurrency()
    {
        return $this->defaultCurrency;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultCurrency($defaultCurrency)
    {
        $this->defaultCurrency = $defaultCurrency;
    }

    public function setMailerConfiguration(MailerConfiguration $configuration)
    {
        $this->mailerConfiguration = $configuration;
    }

    public function getMailerConfiguration(){
        return $this->mailerConfiguration;
    }
}
