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

namespace WellCommerce\Bundle\UserBundle\DataSet;

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\CoreBundle\DataSet\Column\Column;
use WellCommerce\Bundle\CoreBundle\DataSet\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface;

/**
 * Class UserDataSet
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserDataSet extends AbstractDataSet implements DataSetInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'alias'  => 'id',
            'source' => 'user.id',
        ]));

        $collection->add(new Column([
            'alias'  => 'username',
            'source' => 'user.username',
        ]));

        $collection->add(new Column([
            'alias'  => 'email',
            'source' => 'user.email',
        ]));

        $collection->add(new Column([
            'alias'  => 'enabled',
            'source' => 'user.enabled',
        ]));
    }
} 