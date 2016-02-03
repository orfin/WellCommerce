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
namespace WellCommerce\Bundle\ShippingBundle\Repository;

use WellCommerce\Bundle\DoctrineBundle\Repository\AbstractEntityRepository;

/**
 * Class ShippingMethodRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethodRepository extends AbstractEntityRepository implements ShippingMethodRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDefaultShippingMethod()
    {
        return $this->findOneBy([], ['hierarchy' => 'asc']);
    }

    /**
     * {@inheritdoc}
     */
    public function findAllEnabledShippingMethods()
    {
        return $this->findBy(['enabled' => true], ['hierarchy' => 'asc']);
    }
}
