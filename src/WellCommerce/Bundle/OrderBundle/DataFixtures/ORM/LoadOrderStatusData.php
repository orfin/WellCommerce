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
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatus;

/**
 * Class LoadOrderStatusData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadOrderStatusData extends AbstractDataFixture
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (!$this->isEnabled()) {
            return;
        }

        foreach ($this->getStatuses() as $sample) {
            $status = new OrderStatus();
            $status->setEnabled(1);
            $status->setOrderStatusGroup($this->getReference($sample['order_status_group_reference']));
            $status->translate($this->container->getParameter('locale'))->setName($sample['name']);
            $status->translate($this->container->getParameter('locale'))->setDefaultComment($sample['default_comment']);
            $status->mergeNewTranslations();
            $manager->persist($status);
            if (true === $sample['default']) {
                $this->setReference('default_order_status', $status);
            }
        }

        $manager->flush();
    }

    protected function getStatuses()
    {
        return [
            'new'       => [
                'name'                         => 'New',
                'default_comment'              => 'We have received your order.',
                'order_status_group_reference' => 'order_status_group_Processing',
                'default'                      => true
            ],
            'prepared'  => [
                'name'                         => 'Prepared',
                'default_comment'              => 'We are preparing your order.',
                'order_status_group_reference' => 'order_status_group_Prepared',
                'default'                      => false
            ],
            'completed' => [
                'name'                         => 'Completed',
                'default_comment'              => 'Your order has been completed.',
                'order_status_group_reference' => 'order_status_group_Completed',
                'default'                      => false
            ]
        ];
    }
}
