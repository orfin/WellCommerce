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

use WellCommerce\Bundle\DictionaryBundle\Entity\DictionaryInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\EntityFactory;

/**
 * Class DictionaryFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DictionaryFactory extends EntityFactory
{
    public function create() : DictionaryInterface
    {
        /** @var $dictionary DictionaryInterface */
        $dictionary = $this->init();
        $dictionary->setIdentifier('');

        return $dictionary;
    }
}
