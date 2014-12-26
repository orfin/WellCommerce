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

namespace WellCommerce\Bundle\IntlBundle\DataSet;

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\CoreBundle\DataSet\Column\Column;
use WellCommerce\Bundle\CoreBundle\DataSet\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface;

/**
 * Class DictionaryDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class DictionaryDataSet extends AbstractDataSet implements DataSetInterface
{
    /**
     * {@inheritdoc}
     */
    protected function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'alias'  => 'id',
            'source' => 'dictionary.id'
        ]));

        $collection->add(new Column([
            'alias'  => 'identifier',
            'source' => 'dictionary.identifier'
        ]));

        $collection->add(new Column([
            'alias'  => 'translation',
            'source' => 'dictionary_translation.translation'
        ]));

        $collection->add(new Column([
            'alias'  => 'locale',
            'source' => 'dictionary_translation.locale'
        ]));
    }
}