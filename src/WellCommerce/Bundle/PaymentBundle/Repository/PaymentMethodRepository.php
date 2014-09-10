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
namespace WellCommerce\Bundle\PaymentBundle\Repository;

use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class PaymentMethodRepository
 *
 * @package WellCommerce\Bundle\PaymentBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodRepository extends AbstractEntityRepository implements PaymentMethodRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataGridQueryBuilder()
    {
        return parent::getQueryBuilder()->groupBy('payment_method.id')
            ->leftJoin(
                'WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodTranslation',
                'payment_method_translation',
                'WITH',
                'payment_method.id = payment_method_translation.translatable AND payment_method_translation.locale = :locale');

    }
}
