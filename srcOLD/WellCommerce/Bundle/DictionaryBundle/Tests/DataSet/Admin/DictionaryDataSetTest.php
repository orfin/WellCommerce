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

namespace WellCommerce\Bundle\DictionaryBundle\Tests\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class DictionaryDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DictionaryDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('dictionary.dataset.admin');
    }

    protected function getColumns()
    {
        return [
            'id'          => 'dictionary.id',
            'identifier'  => 'dictionary.identifier',
            'translation' => 'dictionary_translation.value',
            'locale'      => 'dictionary_translation.locale',
        ];
    }
}
