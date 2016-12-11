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

namespace WellCommerce\Bundle\ShippingBundle\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;
use WellCommerce\Bundle\CurrencyBundle\Entity\Currency;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethod;
use WellCommerce\Bundle\TaxBundle\Entity\Tax;

/**
 * Class ShippingMethodTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethodTest extends AbstractEntityTestCase
{
    protected function createEntity()
    {
        return new ShippingMethod();
    }
    
    public function providerTestAccessor()
    {
        return [
            ['tax', new Tax()],
            ['currency', new Currency()],
            ['shops', new ArrayCollection()],
            ['costs', new ArrayCollection()],
            ['calculator', 'fixed_price'],
            ['optionsProvider', 'fedex'],
            ['countries', []],
            ['countries', [1, 2, 3]],
            ['createdAt', new \DateTime()],
            ['updatedAt', new \DateTime()],
        ];
    }
}
