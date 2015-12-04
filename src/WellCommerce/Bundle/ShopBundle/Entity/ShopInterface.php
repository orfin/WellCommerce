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
use WellCommerce\Bundle\AppBundle\Entity\MailerConfiguration;
use WellCommerce\Bundle\CompanyBundle\Entity\CompanyAwareInterface;
use WellCommerce\Bundle\CompanyBundle\Entity\CompanyInterface;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\ThemeBundle\Entity\ThemeAwareInterface;

/**
 * Interface ShopInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShopInterface extends TimestampableInterface, BlameableInterface, ThemeAwareInterface, CompanyAwareInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return Collection
     */
    public function getProducts();

    /**
     * @param mixed $products
     */
    public function setProducts(Collection $products);

    /**
     * @return CompanyInterface
     */
    public function getCompany();

    /**
     * @param CompanyInterface $company
     */
    public function setCompany(CompanyInterface $company);

    /**
     * @return Collection
     */
    public function getCategories();

    /**
     * @param Collection $categories
     */
    public function setCategories(Collection $categories);

    /**
     * @return mixed
     */
    public function getProducers();

    /**
     * @param mixed $producers
     */
    public function setProducers(Collection $producers);

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @param string $url
     */
    public function setUrl($url);

    /**
     * @return Collection
     */
    public function getPages();

    /**
     * @param Collection $pages
     */
    public function setPages(Collection $pages);

    /**
     * @return string
     */
    public function getDefaultCountry();

    /**
     * @param string $defaultCountry
     */
    public function setDefaultCountry($defaultCountry);

    /**
     * @return string
     */
    public function getDefaultCurrency();

    /**
     * @param string $defaultCurrency
     */
    public function setDefaultCurrency($defaultCurrency);

    /**
     * @param MailerConfiguration $configuration
     */
    public function setMailerConfiguration(MailerConfiguration $configuration);

    /**
     * @return MailerConfiguration
     */
    public function getMailerConfiguration();
}
