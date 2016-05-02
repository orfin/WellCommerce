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

use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\AppBundle\Entity\MailerConfiguration;
use WellCommerce\Bundle\ClientBundle\Entity\ClientGroupAwareTrait;
use WellCommerce\Bundle\CompanyBundle\Entity\CompanyInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;
use WellCommerce\Bundle\ThemeBundle\Entity\ThemeAwareTrait;

/**
 * Class Shop
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Shop extends AbstractEntity implements ShopInterface
{
    use Timestampable;
    use Blameable;
    use ThemeAwareTrait;
    use ClientGroupAwareTrait;
    
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
    public function getName() : string
    {
        return $this->name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getProducts() : Collection
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
    public function getCompany() : CompanyInterface
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
    public function getCategories() : Collection
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
    public function getProducers() : Collection
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
    public function getUrl() : string
    {
        return $this->url;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPages() : Collection
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
    public function getDefaultCountry() : string
    {
        return $this->defaultCountry;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultCountry(string $defaultCountry)
    {
        $this->defaultCountry = $defaultCountry;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getDefaultCurrency() : string
    {
        return $this->defaultCurrency;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultCurrency(string $defaultCurrency)
    {
        $this->defaultCurrency = $defaultCurrency;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setMailerConfiguration(MailerConfiguration $configuration)
    {
        $this->mailerConfiguration = $configuration;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getMailerConfiguration() : MailerConfiguration
    {
        return $this->mailerConfiguration;
    }
}
