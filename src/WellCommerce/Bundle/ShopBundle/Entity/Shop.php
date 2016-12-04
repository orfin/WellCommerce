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

use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\AppBundle\Entity\MailerConfiguration;
use WellCommerce\Bundle\ClientBundle\Entity\ClientGroupAwareTrait;
use WellCommerce\Bundle\CompanyBundle\Entity\CompanyInterface;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;
use WellCommerce\Bundle\ThemeBundle\Entity\ThemeAwareTrait;

/**
 * Class Shop
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Shop implements ShopInterface
{
    use IdentifiableTrait;
    use Timestampable;
    use Blameable;
    use ThemeAwareTrait;
    use ClientGroupAwareTrait;
    
    protected $name            = '';
    protected $url             = '';
    protected $defaultCountry  = '';
    protected $defaultCurrency = '';
    
    /**
     * @var CompanyInterface
     */
    protected $company;
    
    /**
     * @var MailerConfiguration
     */
    protected $mailerConfiguration;
    
    public function __construct()
    {
        $this->mailerConfiguration = new MailerConfiguration();
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    public function getCompany(): CompanyInterface
    {
        return $this->company;
    }
    
    public function setCompany(CompanyInterface $company = null)
    {
        $this->company = $company;
    }
    
    public function getUrl(): string
    {
        return $this->url;
    }
    
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    public function getDefaultCountry(): string
    {
        return $this->defaultCountry;
    }
    
    public function setDefaultCountry(string $defaultCountry)
    {
        $this->defaultCountry = $defaultCountry;
    }
    
    public function getDefaultCurrency(): string
    {
        return $this->defaultCurrency;
    }
    
    public function setDefaultCurrency(string $defaultCurrency)
    {
        $this->defaultCurrency = $defaultCurrency;
    }
    
    public function setMailerConfiguration(MailerConfiguration $configuration)
    {
        $this->mailerConfiguration = $configuration;
    }
    
    public function getMailerConfiguration(): MailerConfiguration
    {
        return $this->mailerConfiguration;
    }
}
