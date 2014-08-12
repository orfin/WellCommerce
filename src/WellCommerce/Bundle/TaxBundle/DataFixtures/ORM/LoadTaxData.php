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

namespace WellCommerce\Bundle\TaxBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;

/**
 * Class LoadTaxData
 *
 * @package WellCommerce\Bundle\TaxBundle\DataFixtures\ORM
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadTaxData extends AbstractDataFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

    }

    public function getOrder()
    {
        return 1;
    }
}