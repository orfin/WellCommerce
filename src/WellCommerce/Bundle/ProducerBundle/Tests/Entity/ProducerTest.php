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

namespace WellCommerce\Bundle\ProducerBundle\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;
use WellCommerce\Bundle\MediaBundle\Entity\Media;
use WellCommerce\Bundle\ProducerBundle\Entity\Producer;

/**
 * Class ProducerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerTest extends AbstractEntityTestCase
{
    protected function createEntity()
    {
        return new Producer();
    }
    
    public function providerTestAccessor()
    {
        $faker = $this->getFakerGenerator();
        
        return [
            ['photo', new Media()],
            ['deliverers', new ArrayCollection()],
            ['shops', new ArrayCollection()],
            ['createdAt', $faker->dateTime],
            ['updatedAt', $faker->dateTime],
        ];
    }
}
