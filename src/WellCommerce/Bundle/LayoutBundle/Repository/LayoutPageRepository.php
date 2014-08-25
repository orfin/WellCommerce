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
namespace WellCommerce\Bundle\LayoutBundle\Repository;

use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class LayoutPageRepository
 *
 * @package WellCommerce\Bundle\LayoutBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutPageRepository extends AbstractEntityRepository implements LayoutPageRepositoryInterface
{
    public function findAll()
    {
        return $this->findBy([], ['name' => 'ASC']);
    }
}
