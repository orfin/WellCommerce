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

namespace WellCommerce\Bundle\UnitBundle\Tests\Form;

use WellCommerce\Bundle\UnitBundle\Entity\Unit;
use WellCommerce\Bundle\CoreBundle\Test\Form\AbstractFormBuilderTestCase;

/**
 * Class UnitFormBuilderTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UnitFormBuilderTest extends AbstractFormBuilderTestCase
{
    protected function get()
    {
        return $this->container->get('unit.form_builder');
    }

    protected function getSampleFormModelData()
    {
        return new Unit();
    }
}
