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

namespace WellCommerce\Bundle\CmsBundle\Tests\Form;

use WellCommerce\Bundle\CmsBundle\Entity\Contact;
use WellCommerce\Bundle\CoreBundle\Test\Form\AbstractFormBuilderTestCase;

/**
 * Class ContactFormBuilderTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactFormBuilderTest extends AbstractFormBuilderTestCase
{
    protected function get()
    {
        return $this->container->get('contact.form_builder');
    }

    protected function getSampleFormModelData()
    {
        return new Contact();
    }
}
