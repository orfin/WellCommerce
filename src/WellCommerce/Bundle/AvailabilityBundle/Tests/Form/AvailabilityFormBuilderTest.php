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

namespace WellCommerce\Bundle\AvailabilityBundle\Tests\Form;

use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;

/**
 * Class AvailabilityFormBuilderTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityFormBuilderTest extends AbstractTestCase
{
    public function testFormIsCreated()
    {
        $form = $this->container->get('availability.form_builder')->createForm([
            'name' => 'availability'
        ], null);

        $this->assertInstanceOf('WellCommerce\Bundle\FormBundle\Elements\FormInterface', $form);
    }

    public function testFormIsAbleToReturnDefaultModelData()
    {
        $resource = $this->container->get('availability.repository')->findOneBy([]);

        $form = $this->container->get('availability.form_builder')->createForm([
            'name' => 'availability'
        ], $resource);

        $this->assertEquals($resource, $form->getModelData());
    }
}
