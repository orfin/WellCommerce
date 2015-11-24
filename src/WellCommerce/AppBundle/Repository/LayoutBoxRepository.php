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
namespace WellCommerce\AppBundle\Repository;

use WellCommerce\CoreBundle\Repository\AbstractEntityRepository;
use WellCommerce\AppBundle\Collection\LayoutBoxCollection;

/**
 * Class LayoutBoxRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxRepository extends AbstractEntityRepository implements LayoutBoxRepositoryInterface
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
