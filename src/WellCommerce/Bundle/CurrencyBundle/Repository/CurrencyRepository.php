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
namespace WellCommerce\Bundle\CurrencyBundle\Repository;

use Symfony\Component\Intl\Intl;
use WellCommerce\Bundle\DoctrineBundle\Repository\EntityRepository;

/**
 * Class CurrencyRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyRepository extends EntityRepository implements CurrencyRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getCurrenciesToSelect()
    {
        return Intl::getCurrencyBundle()->getCurrencyNames();
    }
}
