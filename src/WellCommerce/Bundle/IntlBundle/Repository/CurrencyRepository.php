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
namespace WellCommerce\Bundle\IntlBundle\Repository;

use Symfony\Component\Intl\Intl;
use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class CurrencyRepository
 *
 * @package WellCommerce\Bundle\IntlBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyRepository extends AbstractEntityRepository implements CurrencyRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getCurrenciesToSelect()
    {
        $currencies = Intl::getCurrencyBundle()->getCurrencyNames();

        return $currencies;
    }
}
