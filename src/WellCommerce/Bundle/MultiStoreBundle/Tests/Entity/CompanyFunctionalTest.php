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

namespace WellCommerce\Bundle\MultiStoreBundle\Tests\Entity;

use WellCommerce\Bundle\CoreBundle\Tests\AbstractTestCase;

/**
 * Class CompanyFunctionalTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyFunctionalTest extends AbstractTestCase
{
    public function testAtLeastOneCompanyExists()
    {
        $repository = $this->em->getRepository('WellCommerceMultiStoreBundle:Company');
        $companies  = $repository->findAll();

        $this->assertGreaterThan(0, count($companies));
    }
}