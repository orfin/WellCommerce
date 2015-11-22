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

namespace WellCommerce\CommonBundle\Factory;

use WellCommerce\CommonBundle\Entity\Dictionary;
use WellCommerce\AppBundle\Factory\AbstractFactory;

/**
 * Class DictionaryFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DictionaryFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\CommonBundle\Entity\DictionaryInterface
     */
    public function create()
    {
        $dictionary = new Dictionary();

        return $dictionary;
    }
}
