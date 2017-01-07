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

namespace WellCommerce\Bundle\LayoutBundle\DataSet\Admin;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class LayoutBoxDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'         => 'layout_box.id',
            'name'       => 'layout_box_translation.name',
            'identifier' => 'layout_box.identifier',
            'boxType'    => 'layout_box.boxType',
        ]);
    }
    
    protected function createQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->repository->getQueryBuilder();
        $queryBuilder->groupBy('layout_box.id');
        $queryBuilder->leftJoin('layout_box.translations', 'layout_box_translation');
        
        return $queryBuilder;
    }
}
