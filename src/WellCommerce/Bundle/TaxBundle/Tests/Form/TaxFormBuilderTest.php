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

namespace WellCommerce\Bundle\TaxBundle\Tests\Form;

use WellCommerce\Bundle\TaxBundle\Entity\Tax;
use WellCommerce\Bundle\CoreBundle\Test\Form\AbstractFormBuilderTestCase;

/**
 * Class TaxFormBuilderTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxFormBuilderTest extends AbstractFormBuilderTestCase
{
    protected function getService()
    {
        return $this->container->get('tax.form_builder');
    }

    protected function getSampleFormModelData()
    {
        return new Tax();
    }
}
