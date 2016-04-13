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

namespace WellCommerce\Bundle\OrderBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\DoctrineBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatusGroup;

/**
 * Class LoadOrderStatusGroupData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadOrderStatusGroupData extends AbstractDataFixture
{

    public static $samples = ['Processing', 'Prepared', 'Completed', 'Cancelled'];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (!$this->isEnabled()) {
            return;
        }

        foreach (self::$samples as $name) {
            $orderStatusGroup = new OrderStatusGroup();
            $orderStatusGroup->translate($this->container->getParameter('locale'))->setName($name);
            $orderStatusGroup->mergeNewTranslations();
            $manager->persist($orderStatusGroup);
            $this->setReference('order_status_group_' . $name, $orderStatusGroup);
        }

        $manager->flush();
    }
}
