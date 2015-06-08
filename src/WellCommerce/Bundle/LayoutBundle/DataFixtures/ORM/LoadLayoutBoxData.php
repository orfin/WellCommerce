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

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutBox;

/**
 * Class LoadClientData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadLayoutBoxData extends AbstractDataFixture
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
        $this->createProductBoxes();

        $manager->flush();
    }

    protected function createCategoryBoxes()
    {
        $boxes = [
            'CategoryMenuBox'     => [
                'identifier' => 'category_menu',
                'name'       => 'Categories',
                'settings'   => []
            ],
            'CategoryInfoBox'     => [
                'identifier' => 'category_info',
                'name'       => 'Category',
                'settings'   => []
            ],
            'CategoryProductsBox' => [
                'identifier' => 'category_products',
                'name'       => 'Category products',
                'settings'   => [
                    'per_page' => 10
                ]
            ],
        ];

        foreach ($boxes as $type => $params) {
            $this->createLayoutBox($type, $params['identifier'], $params['name'], $params['settings']);
        }
    }

    protected function createClientBoxes()
    {
        $boxes = [
            'ClientRegistrationBox'   => [
                'identifier' => 'client_registration',
                'name'       => 'Sign-in'
            ],
            'ClientLoginBox'          => [
                'identifier' => 'client_login',
                'name'       => 'Sign-up'
            ],
            'ClientOrderBox'          => [
                'identifier' => 'client_order',
                'name'       => 'Orders'
            ],
            'ClientSettingsBox'       => [
                'identifier' => 'client_settings',
                'name'       => 'Account settings'
            ],
            'ClientForgotPasswordBox' => [
                'identifier' => 'client_forgot_password',
                'name'       => 'Password reset'
            ],
            'ClientAddressBookBox'    => [
                'identifier' => 'client_address_book',
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
                'identifier' => 'producer_menu',
                'name'       => 'Producers'
            ],
            'ProducerProductsBox' => [
                'identifier' => 'producer_products',
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
            0 => [
                'type'       => 'ProductStatusBox',
                'identifier' => 'product_bestseller',
                'name'       => 'Bestsellers',
                'settings'   => [
                    'status' => $this->getReference('product_status_Bestsellers')->getId()
                ]
            ],
            1 => [
                'type'       => 'ProductStatusBox',
                'identifier' => 'product_new_arrivals',
                'name'       => 'New arrivals',
                'settings'   => [
                    'status' => $this->getReference('product_status_New arrivals')->getId()
                ]
            ],
            2 => [
                'type'       => 'ProductShowcaseBox',
                'identifier' => 'product_showcase',
                'name'       => 'Showcase',
                'settings'   => [
                    'status' => $this->getReference('product_status_Featured')->getId()
                ]
            ],
            3 => [
                'type'       => 'ProductStatusBox',
                'identifier' => 'product_dynamic_status',
                'name'       => 'Dynamic product status box',
                'settings'   => []
            ],
        ];

        foreach ($boxes as $index => $params) {
            $this->createLayoutBox($params['type'], $params['identifier'], $params['name'], $params['settings']);
        }
    }

    protected function createCheckoutBoxes()
    {
        $boxes = [
            'CartBox'         => [
                'identifier' => 'cart',
                'name'       => 'Cart'
            ],
            'CheckoutBox'     => [
                'identifier' => 'checkout',
                'name'       => 'Checkout'
            ],
            'FinalizationBox' => [
                'identifier' => 'finalization',
                'name'       => 'Summary'
            ],
            'PaymentBox'      => [
                'identifier' => 'payment',
                'name'       => 'Payment'
            ],
        ];

        foreach ($boxes as $type => $params) {
            $this->createLayoutBox($type, $params['identifier'], $params['name']);
        }
    }

    protected function createProductBoxes()
    {
        $boxes = [
            'ProductInfoBox'              => [
                'identifier' => 'product_info',
                'name'       => 'Product'
            ],
            'ProductLayeredNavigationBox' => [
                'identifier' => 'layered_navigation',
                'name'       => 'Layered navigation'
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

}
