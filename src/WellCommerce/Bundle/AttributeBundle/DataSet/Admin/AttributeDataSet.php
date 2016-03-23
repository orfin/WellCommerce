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

namespace WellCommerce\Bundle\AttributeBundle\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class AttributeDataSet
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'     => 'attribute.id',
            'name'   => 'attribute_translation.name',
            'groups' => 'GROUP_CONCAT(DISTINCT attribute_groups_translation.name ORDER BY attribute_groups_translation.name ASC SEPARATOR \', \')',
        ]);
    }
}
