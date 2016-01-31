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

namespace WellCommerce\Bundle\PluginBundle\DependencyInjection\Compiler;

use WellCommerce\Bundle\CoreBundle\DependencyInjection\Compiler\AbstractCollectionPass;

/**
 * Class RegisterClassMetadataVisitorPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RegisterClassMetadataVisitorPass extends AbstractCollectionPass
{
    /**
     * @var string
     */
    protected $collectionServiceId = 'plugin.class_metadata.visitor_collection';

    /**
     * @var string
     */
    protected $serviceTag = 'plugin.class_metadata.visitor';
}
