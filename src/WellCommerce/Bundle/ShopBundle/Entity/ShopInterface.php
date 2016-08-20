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

use WellCommerce\Bundle\AppBundle\Entity\MailerConfiguration;
use WellCommerce\Bundle\ClientBundle\Entity\ClientGroupAwareInterface;
use WellCommerce\Bundle\CompanyBundle\Entity\CompanyAwareInterface;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;
use WellCommerce\Bundle\ThemeBundle\Entity\ThemeAwareInterface;

/**
 * Interface ShopInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShopInterface extends
    EntityInterface,
    ClientGroupAwareInterface,
    TimestampableInterface,
    BlameableInterface,
    ThemeAwareInterface,
    CompanyAwareInterface
{
    /**
     * @return string
     */
    public function getName() : string;
    
    /**
     * @param string $name
     */
    public function setName(string $name);
    
    /**
     * @return string
     */
    public function getUrl() : string;
    
    /**
     * @param string $url
     */
    public function setUrl(string $url);
    
    /**
     * @return string
     */
    public function getDefaultCountry() : string;
    
    /**
     * @param string $defaultCountry
     */
    public function setDefaultCountry(string $defaultCountry);
    
    /**
     * @return string
     */
    public function getDefaultCurrency() : string;
    
    /**
     * @param string $defaultCurrency
     */
    public function setDefaultCurrency(string $defaultCurrency);
    
    /**
     * @param MailerConfiguration $configuration
     */
    public function setMailerConfiguration(MailerConfiguration $configuration);
    
    /**
     * @return MailerConfiguration
     */
    public function getMailerConfiguration() : MailerConfiguration;
}
