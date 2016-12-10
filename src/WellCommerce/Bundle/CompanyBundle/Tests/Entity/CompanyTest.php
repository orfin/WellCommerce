<?php
/**
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\CompanyBundle\Tests\Entity;

use WellCommerce\Bundle\CompanyBundle\Entity\Company;
use WellCommerce\Bundle\CompanyBundle\Entity\CompanyAddress;
use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;

/**
 * Class CompanyTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyTest extends AbstractEntityTestCase
{
    protected function createEntity()
    {
        return new Company();
    }
    
    public function providerTestAccessor()
    {
        $faker = $this->getFakerGenerator();
        
        return [
            ['address', new CompanyAddress()],
            ['name', $faker->company],
            ['shortName', $faker->company],
        ];
    }
}
