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
namespace WellCommerce\Bundle\TaxBundle\Repository;

use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class TaxRepository
 *
 * @package WellCommerce\Bundle\TaxBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxRepository extends AbstractEntityRepository implements TaxRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataGridQueryBuilder()
    {
        return parent::getQueryBuilder()->groupBy('tax.id')
            ->leftJoin(
                'WellCommerce\Bundle\TaxBundle\Entity\TaxTranslation',
                'tax_translation',
                'WITH',
                'tax.id = tax_translation.translatable AND tax_translation.locale = :locale')
            ->setParameter('locale', $this->getCurrentLocale());

    }
}
