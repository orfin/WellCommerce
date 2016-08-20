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
    public function getCompany()
    {
        return $this->company;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCompany(CompanyInterface $company = null)
    {
        $this->company = $company;
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
