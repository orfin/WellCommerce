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

namespace WellCommerce\Bundle\OrderBundle\Repository;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CoreBundle\Repository\EntityRepository;

/**
 * Class OrderProductRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderProductRepository extends EntityRepository implements OrderProductRepositoryInterface
{
}
