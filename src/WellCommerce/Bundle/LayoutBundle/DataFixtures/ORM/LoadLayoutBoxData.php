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

namespace WellCommerce\Bundle\ClientBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutBox;

/**
 * Class LoadClientData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadLayoutBoxData extends AbstractDataFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * @var ObjectManager
     */
    protected $manager;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->createCategoryBoxes();
        $this->createClientBoxes();
        $this->createProducerBoxes();
        $this->createProductStatusesBoxes();
        $this->createCheckoutBoxes();

        $manager->flush();
    }

    protected function createCategoryBoxes()
    {
        $boxes = [
            'CategoryMenuBox'     => [
                'identifier' => 'category.menu.box',
                'name'       => 'Categories'
            ],
            'CategoryInfoBox'     => [
                'identifier' => 'category.info.box',
                'name'       => 'Category'
            ],
            'CategoryProductsBox' => [
                'identifier' => 'category.products.box',
                'name'       => 'Category products'
            ],
        ];

        foreach ($boxes as $type => $params) {
            $this->createLayoutBox($type, $params['identifier'], $params['name']);
        }
    }

    protected function createClientBoxes()
    {
        $boxes = [
            'ClientRegistrationBox'   => [
                'identifier' => 'client.registration.box',
                'name'       => 'Sign-in'
            ],
            'ClientLoginBox'          => [
                'identifier' => 'client.login.box',
                'name'       => 'Sign-up'
            ],
            'ClientOrderBox'          => [
                'identifier' => 'client.order.box',
                'name'       => 'Orders'
            ],
            'ClientSettingsBox'       => [
                'identifier' => 'client.settings.box',
                'name'       => 'Account settings'
            ],
            'ClientForgotPasswordBox' => [
                'identifier' => 'client.forgot_password.box',
                'name'       => 'Password reset'
            ],
            'ClientAddressBookBox'    => [
                'identifier' => 'client.address_book.box',
                'name'       => 'Address book'
            ],
        ];

        foreach ($boxes as $type => $params) {
            $this->createLayoutBox($type, $params['identifier'], $params['name']);
        }
    }

    protected function createProducerBoxes()
    {
        $boxes = [
            'ProducerMenuBox'     => [
                'identifier' => 'producer.menu.box',
                'name'       => 'Producers'
            ],
            'CategoryInfoBox'     => [
                'identifier' => 'producer.info.box',
                'name'       => 'Producer'
            ],
            'CategoryProductsBox' => [
                'identifier' => 'producer.products.box',
                'name'       => 'Producer products'
            ],
        ];

        foreach ($boxes as $type => $params) {
            $this->createLayoutBox($type, $params['identifier'], $params['name']);
        }
    }

    protected function createProductStatusesBoxes()
    {
        $boxes = [
            'ProductBestsellerBox' => [
                'identifier' => 'product.bestseller.box',
                'name'       => 'Bestsellers'
            ],
            'ProductPromotionBox'  => [
                'identifier' => 'product.promotion.box',
                'name'       => 'Promotions'
            ],
            'ProductNewBox'        => [
                'identifier' => 'product.new.box',
                'name'       => 'New arrivals'
            ],
            'ProductShowcaseBox'   => [
                'identifier' => 'product.showcase.box',
                'name'       => 'Showcase'
            ],
        ];

        foreach ($boxes as $type => $params) {
            $this->createLayoutBox($type, $params['identifier'], $params['name']);
        }
    }

    protected function createCheckoutBoxes()
    {
        $boxes = [
            'CartBox'         => [
                'identifier' => 'cart.box',
                'name'       => 'Cart'
            ],
            'CheckoutBox'     => [
                'identifier' => 'checkout.box',
                'name'       => 'Checkout'
            ],
            'FinalizationBox' => [
                'identifier' => 'finalization.box',
                'name'       => 'Summary'
            ],
            'PaymentBox'      => [
                'identifier' => 'payment.box',
                'name'       => 'Payment'
            ],
        ];

        foreach ($boxes as $type => $params) {
            $this->createLayoutBox($type, $params['identifier'], $params['name']);
        }
    }

    protected function createLayoutBox($type, $identifier, $name, $settings = [])
    {
        $layoutBox = new LayoutBox();
        $layoutBox->setBoxType($type);
        $layoutBox->setIdentifier($identifier);
        $layoutBox->setSettings($settings);
        $layoutBox->translate('en')->setName($name);
        $layoutBox->mergeNewTranslations();

        $this->manager->persist($layoutBox);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 4;
    }
}
