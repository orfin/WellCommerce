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

namespace WellCommerce\Bundle\DelivererBundle\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;
use WellCommerce\Bundle\DelivererBundle\Entity\Deliverer;
use WellCommerce\Bundle\ProducerBundle\Entity\Producer;

/**
 * Class DelivererTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererTest extends AbstractEntityTestCase
{
    protected function createEntity()
    {
        return new Deliverer();
    }
    
    public function providerTestAccessor()
    {
        return [
            ['producers', new ArrayCollection()],
            ['producers', new ArrayCollection([new Producer()])],
            ['producers', new ArrayCollection([new Producer(), new Producer()])],
            ['createdAt', new \DateTime()],
            ['updatedAt', new \DateTime()],
        ];
    }
}
