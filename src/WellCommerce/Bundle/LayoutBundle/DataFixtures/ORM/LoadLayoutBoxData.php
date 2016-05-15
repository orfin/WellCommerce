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

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\DoctrineBundle\DataFixtures\AbstractDataFixture;
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
        if (!$this->isEnabled()) {
            return;
        }

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
            'CategoryMenu'     => [
                'identifier' => 'category_menu',
                'name'       => 'Categories',
                'settings'   => []
            ],
            'CategoryInfo'     => [
                'identifier' => 'category_info',
                'name'       => 'Category',
                'settings'   => []
            ],
            'CategoryProducts' => [
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
            'ClientRegistration'   => [
                'identifier' => 'client_registration',
                'name'       => 'Sign-in'
            ],
            'ClientLogin'          => [
                'identifier' => 'client_login',
                'name'       => 'Sign-up'
            ],
            'ClientOrder'          => [
                'identifier' => 'client_order',
                'name'       => 'Orders'
            ],
            'ClientSettings'       => [
                'identifier' => 'client_settings',
                'name'       => 'Account settings'
            ],
            'ClientMenu'           => [
                'identifier' => 'client_menu',
                'name'       => 'Client menu'
            ],
            'ClientWishlist'             => [
                'identifier' => 'client_wishlist',
                'name'       => 'Client Wishlist'
            ],
            'ClientForgotPassword' => [
                'identifier' => 'client_forgot_password',
                'name'       => 'Password reset'
            ],
            'ClientAddressBook'    => [
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
            'ProducerMenu'     => [
                'identifier' => 'producer_menu',
                'name'       => 'Producers'
            ],
            'ProducerProducts' => [
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
                'type'       => 'ProductStatus',
                'identifier' => 'product_bestseller',
                'name'       => 'Bestsellers',
                'settings'   => [
                    'status' => $this->getReference('product_status_Bestsellers')->getId()
                ]
            ],
            1 => [
                'type'       => 'ProductStatus',
                'identifier' => 'product_new_arrivals',
                'name'       => 'New arrivals',
                'settings'   => [
                    'status' => $this->getReference('product_status_New arrivals')->getId()
                ]
            ],
            2 => [
                'type'       => 'ProductShowcase',
                'identifier' => 'product_showcase',
                'name'       => 'Showcase',
                'settings'   => [
                    'status' => $this->getReference('product_status_Featured')->getId()
                ]
            ],
            3 => [
                'type'       => 'ProductStatus',
                'identifier' => 'product_dynamic_status',
                'name'       => 'Dynamic product status box',
                'settings'   => []
            ],
            4 => [
                'type'       => 'Search',
                'identifier' => 'search',
                'name'       => 'Product search box',
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
            'Cart'         => [
                'identifier' => 'cart',
                'name'       => 'Cart'
            ],
            'Checkout'     => [
                'identifier' => 'checkout',
                'name'       => 'Checkout'
            ],
            'Finalization' => [
                'identifier' => 'finalization',
                'name'       => 'Summary'
            ],
            'Payment'      => [
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
            'ProductInfo'       => [
                'identifier' => 'product_info',
                'name'       => 'Product'
            ],
            'Review'            => [
                'identifier' => 'review',
                'name'       => 'Product reviews'
            ],
            'LayeredNavigation' => [
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
        $layoutBox->translate($this->getDefaultLocale())->setName($name);
        $layoutBox->mergeNewTranslations();

        $this->manager->persist($layoutBox);
    }

}
