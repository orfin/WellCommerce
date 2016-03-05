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

namespace WellCommerce\Bundle\ThemeBundle\Tests\Form;

use WellCommerce\Bundle\CoreBundle\Test\Form\AbstractFormBuilderTestCase;

/**
 * Class ThemeFormBuilderTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ThemeFormBuilderTest extends AbstractFormBuilderTestCase
{
    protected function getFormBuilderService()
    {
        return $this->container->get('theme.form_builder.admin');
    }

    protected function getFactoryService()
    {
        return $this->container->get('theme.factory');
    }
}
