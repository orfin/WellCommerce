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
namespace WellCommerce\Bundle\ContactBundle\Repository;

use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class ContactRepository
 *
 * @package WellCommerce\Bundle\ContactBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactRepository extends AbstractEntityRepository implements ContactRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataGridQueryBuilder()
    {
        return parent::getQueryBuilder()
            ->leftJoin(
                'WellCommerce\Bundle\ContactBundle\Entity\ContactTranslation',
                'contact_translation',
                'WITH',
                'contact.id = contact_translation.translatable AND contact_translation.locale = :locale')
            ->setParameter('locale', $this->getCurrentLocale());

    }
}
