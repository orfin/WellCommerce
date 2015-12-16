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

namespace WellCommerce\Bundle\ProductStatusBundle\Tests\Form\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Form\AbstractFormBuilderTestCase;

/**
 * Class ProductStatusFormBuilderTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusFormBuilderTest extends AbstractFormBuilderTestCase
{
    protected function getFormBuilderService()
    {
        return $this->container->get('product_status.form_builder.admin');
    }

    protected function getFactoryService()
    {
        return $this->container->get('product_status.factory');
    }
}
