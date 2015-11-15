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

namespace WellCommerce\Bundle\CatalogBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\CatalogBundle\Entity\Deliverer;

/**
 * Class LoadDelivererData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadDelivererData extends AbstractDataFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $fakerGenerator = $this->getFakerGenerator();

        $deliverer = new Deliverer();
        $name      = $fakerGenerator->company;
        $deliverer->translate('en')->setName($name);
        $deliverer->mergeNewTranslations();
        $manager->persist($deliverer);
        $manager->flush();

        $this->setReference('deliverer', $deliverer);
    }
}
