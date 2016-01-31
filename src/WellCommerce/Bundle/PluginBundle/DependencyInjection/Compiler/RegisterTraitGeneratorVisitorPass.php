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
 * Class RegisterTraitGeneratorVisitorPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RegisterTraitGeneratorVisitorPass extends AbstractCollectionPass
{
    /**
     * @var string
     */
    protected $collectionServiceId = 'plugin.entity_extra_generator.visitor_collection';

    /**
     * @var string
     */
    protected $serviceTag = 'plugin.entity_extra_generator.visitor';
}
