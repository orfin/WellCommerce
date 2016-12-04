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

namespace WellCommerce\Bundle\CouponBundle\Tests\Form\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Form\AbstractFormBuilderTestCase;

/**
 * Class CouponFormBuilderTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CouponFormBuilderTest extends AbstractFormBuilderTestCase
{
    protected function getFormBuilderService()
    {
        return $this->container->get('coupon.form_builder.admin');
    }
    
    protected function getDefaultFormData()
    {
        return $this->container->get('coupon.manager')->initResource();
    }
}
