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

namespace WellCommerce\CatalogBundle\Tests\Form\Admin;

use WellCommerce\AppBundle\Test\Form\AbstractFormBuilderTestCase;

/**
 * Class ProducerFormBuilderTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerFormBuilderTest extends AbstractFormBuilderTestCase
{
    protected function getFormBuilderService()
    {
        return $this->container->get('producer.form_builder.admin');
    }

    protected function getFactoryService()
    {
        return $this->container->get('producer.factory');
    }
}
