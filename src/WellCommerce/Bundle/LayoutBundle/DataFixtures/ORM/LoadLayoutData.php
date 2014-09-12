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

namespace WellCommerce\Bundle\LayoutBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutBoxType;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutPage;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutTheme;

/**
 * Class LoadLayoutData
 *
 * @package WellCommerce\Bundle\LayoutBundle\DataFixtures\ORM
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadLayoutData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $layoutTheme = new LayoutTheme();
        $layoutTheme->setName('Development');
        $layoutTheme->setFolder('development');
        $manager->persist($layoutTheme);

        $pages = $this->getLayoutPages();
        foreach ($pages as $page) {
            $layoutPage = new LayoutPage();
            $layoutPage->setName($page);
            $manager->persist($layoutPage);
        }

        $types = $this->getLayoutBoxTypes();
        foreach ($types as $type) {
            $layoutBoxType = new LayoutBoxType();
            $layoutBoxType->setType($type);
            $layoutBoxType->setVendor('WellCommerce');
            $manager->persist($layoutBoxType);
        }

        $manager->flush();
    }

    private function getLayoutPages()
    {
        return [
            'HomePage',
            'Contact',
            'Product',
            'Category',
            'Promotions',
            'News',
            'Producer',
            'Search',
            'Cart',
            'Checkout',
            'Finalization',
            'Payment',
            'ClientWishList',
            'ClientOrder',
            'ClientAddress',
            'ClientSettings',
            'Login',
            'Registration',
            'ForgotPassword',
            'Page',
            'SiteMap',
            'Blog',
            'Newsletter',
        ];
    }

    private function getLayoutBoxTypes()
    {
        return [
            'CategoryBox',
            'ProducerBox',
            'ProductBox',
            'PromotionsBox',
            'NewsBox',
            'SearchBox',
            'CartBox',
            'CheckoutBox',
            'FinalizationBox',
            'PaymentBox',
            'ClientWishListBox',
            'ClientOrderBox',
            'ClientAddressBox',
            'ClientSettingsBox',
            'LoginBox',
            'RegistrationBox',
            'ForgotPasswordBox',
            'PageBox',
            'SiteMapBox',
            'BlogBox',
            'NewsletterBox',
        ];
    }
}