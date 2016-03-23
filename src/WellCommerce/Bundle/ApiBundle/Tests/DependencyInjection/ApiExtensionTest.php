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

namespace WellCommerce\Bundle\ApiBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class ApiExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ApiExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    public function getRequiredServices()
    {
        return [
            'services' => [
                [
                    'api.security.token_authenticator',
                    'api.request_handler.collection',
                    'api.controller.front',
                    'api.generate_serialization_metadata.command',
                    'api.serialization.metadata_loader',
                    'availability.api.request_handler',
                    'category.api.request_handler',
                    'client.api.request_handler',
                    'company.api.request_handler',
                    'contact.api.request_handler',
                    'coupon.api.request_handler',
                    'currency.api.request_handler',
                    'deliverer.api.request_handler',
                    'locale.api.request_handler',
                    'media.api.request_handler',
                    'news.api.request_handler',
                    'order.api.request_handler',
                    'page.api.request_handler',
                    'payment_method.api.request_handler',
                    'producer.api.request_handler',
                    'product.api.request_handler',
                    'product_status.api.request_handler',
                    'review.api.request_handler',
                    'shipping_method.api.request_handler',
                    'shop.api.request_handler',
                    'tax.api.request_handler',
                    'unit.api.request_handler',
                ]
            ],
        ];
    }
}
