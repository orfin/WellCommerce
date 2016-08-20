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

namespace WellCommerce\Component\Search\Model;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;

/**
 * Interface TypeInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface TypeInterface
{
    public function getName() : string;

    public function createDocument(EntityInterface $entity, string $locale) : DocumentInterface;

    public function getFields() : Collection;
}
