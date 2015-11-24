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

namespace WellCommerce\AppBundle\Tests\Entity;

use WellCommerce\AppBundle\Entity\Category;
use WellCommerce\CoreBundle\Test\Entity\AbstractEntityTestCase;

/**
 * Class CategoryTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryTest extends AbstractEntityTestCase
{
    public function testNewEntityFailsValidation()
    {
        $entity = new Category();
        $entity->translate('en')->setName('Test');
        $entity->mergeNewTranslations();

        $errors = $this->validator->validate($entity);
        $this->assertFalse(0 === count($errors));
    }
}
