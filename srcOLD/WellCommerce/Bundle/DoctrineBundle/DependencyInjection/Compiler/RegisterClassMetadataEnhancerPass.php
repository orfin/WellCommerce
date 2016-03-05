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

namespace WellCommerce\Bundle\DoctrineBundle\DependencyInjection\Compiler;

use WellCommerce\Bundle\CoreBundle\DependencyInjection\Compiler\AbstractCollectionPass;

/**
 * Class RegisterClassMetadataEnhancerPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RegisterClassMetadataEnhancerPass extends AbstractCollectionPass
{
    /**
     * @var string
     */
    protected $collectionServiceId = 'doctrine.class_metadata.enhancer_collection';

    /**
     * @var string
     */
    protected $serviceTag = 'doctrine.mapping.enhancer';
}
