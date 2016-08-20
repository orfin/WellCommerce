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

namespace WellCommerce\Bundle\CoreBundle\Enhancer\ClassMetadata;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

/**
 * Interface ClassMetadataEnhancerTraverserInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClassMetadataEnhancerTraverserInterface
{
    /**
     * @param ClassMetadata $metadata
     */
    public function traverse(ClassMetadataInfo $metadata);
}
