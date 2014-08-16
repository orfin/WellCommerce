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
namespace WellCommerce\Bundle\AvailabilityBundle\Repository;

use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class AvailabilityRepository
 *
 * @package WellCommerce\Bundle\AvailabilityBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityRepository extends AbstractEntityRepository implements AvailabilityRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataGridQueryBuilder()
    {
        return parent::getQueryBuilder()->groupBy('availability.id')
            ->leftJoin(
                'WellCommerce\Bundle\AvailabilityBundle\Entity\AvailabilityTranslation',
                'availability_translation',
                'WITH',
                'availability.id = availability_translation.translatable AND availability_translation.locale = :locale');

    }
}
