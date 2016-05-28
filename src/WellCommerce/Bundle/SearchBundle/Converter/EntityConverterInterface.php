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

namespace WellCommerce\Bundle\SearchBundle\Converter;

use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\SearchBundle\Document\DocumentInterface;
use WellCommerce\Bundle\SearchBundle\Type\IndexTypeInterface;

/**
 * Interface EntityConverterInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface EntityConverterInterface
{
    public function convert(EntityInterface $entity, IndexTypeInterface $type, string $locale) : DocumentInterface;
}
