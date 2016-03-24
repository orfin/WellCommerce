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

namespace WellCommerce\Bundle\ApiBundle\DependencyInjection\Compiler;

use WellCommerce\Bundle\CoreBundle\DependencyInjection\Compiler\AbstractCollectionPass;

/**
 * Class RegisterRequestHandlerPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RegisterRequestHandlerPass extends AbstractCollectionPass
{
    /**
     * @var string
     */
    protected $collectionServiceId = 'api.request_handler.collection';

    /**
     * @var string
     */
    protected $serviceTag = 'api.request_handler';
}
