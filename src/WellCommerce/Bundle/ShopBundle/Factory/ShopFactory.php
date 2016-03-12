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

namespace WellCommerce\Bundle\ShopBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\AppBundle\Entity\MailerConfiguration;
use WellCommerce\Bundle\CompanyBundle\Entity\CompanyInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\ShopBundle\Entity\ShopInterface;
use WellCommerce\Bundle\ThemeBundle\Entity\ThemeInterface;

/**
 * Class ShopFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = ShopInterface::class;

    /**
     * @return ShopInterface
     */
    public function create()
    {
        /** @var  $shop ShopInterface */
        $shop = $this->init();
        $shop->setName('');
        $shop->setUrl('');
        $shop->setProducts(new ArrayCollection());
        $shop->setCategories(new ArrayCollection());
        $shop->setPages(new ArrayCollection());
        $shop->setProducers(new ArrayCollection());
        $shop->setMailerConfiguration(new MailerConfiguration());
        $shop->setCompany($this->getDefaultCompany());
        $shop->setTheme($this->getDefaultTheme());
        $shop->setDefaultCurrency($this->getDefaultCurrency()->getCode());
        $shop->setDefaultCountry('');

        return $shop;
    }

    private function getDefaultCompany() : CompanyInterface
    {
        return $this->get('company.repository')->findOneBy([]);
    }

    private function getDefaultTheme() : ThemeInterface
    {
        return $this->get('theme.repository')->findOneBy([]);
    }
}
