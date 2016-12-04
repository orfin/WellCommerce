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
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
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
    public function getName(): string;
    
    public function setName(string $name);
    
    public function getUrl(): string;
    
    public function setUrl(string $url);
    
    public function getDefaultCountry(): string;
    
    public function setDefaultCountry(string $defaultCountry);
    
    public function getDefaultCurrency(): string;
    
    public function setDefaultCurrency(string $defaultCurrency);
    
    public function setMailerConfiguration(MailerConfiguration $configuration);
    
    public function getMailerConfiguration(): MailerConfiguration;
}
