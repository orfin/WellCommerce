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

use WellCommerce\Bundle\DoctrineBundle\Repository\EntityRepository;
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxCollection;

/**
 * Class LayoutBoxRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxRepository extends EntityRepository implements LayoutBoxRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getLayoutBoxesCollection()
    {
        $boxes = $this->findAll();

        return new LayoutBoxCollection($boxes);
    }
}
