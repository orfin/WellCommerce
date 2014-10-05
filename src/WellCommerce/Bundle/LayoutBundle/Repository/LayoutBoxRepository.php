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
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxCollection;

/**
 * Class LayoutBoxRepository
 *
 * @package WellCommerce\Bundle\LayoutBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxRepository extends AbstractEntityRepository implements LayoutBoxRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataGridQueryBuilder()
    {
        $queryBuilder = parent::getQueryBuilder();
        $queryBuilder->groupBy('layout_box.id');
        $queryBuilder->leftJoin(
            'WellCommerce\Bundle\LayoutBundle\Entity\LayoutBoxTranslation',
            'layout_box_translation',
            'WITH',
            'layout_box.id = layout_box_translation.translatable AND layout_box_translation.locale = :locale');

        return $queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getLayoutBoxesCollection()
    {
        $boxes = $this->findAll();
        return new LayoutBoxCollection($boxes);
    }
}
