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

namespace WellCommerce\Bundle\DictionaryBundle\Factory;

use WellCommerce\Bundle\CoreBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\DictionaryBundle\Entity\Dictionary;
use WellCommerce\Bundle\DictionaryBundle\Entity\DictionaryInterface;

/**
 * Class DictionaryFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DictionaryFactory extends AbstractEntityFactory
{
    public function create() : DictionaryInterface
    {
        $dictionary = new Dictionary();
        $dictionary->setIdentifier('');

        return $dictionary;
    }
}
