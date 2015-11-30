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

namespace WellCommerce\Bundle\AppBundle\DependencyInjection\Compiler;

use WellCommerce\Bundle\CoreBundle\DependencyInjection\Compiler\AbstractCollectionPass;

/**
 * Class RegisterShippingMethodCalculatorPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RegisterShippingMethodCalculatorPass extends AbstractCollectionPass
{
    /**
     * @var string
     */
    protected $collectionServiceId = 'shipping_method.calculator.collection';

    /**
     * @var string
     */
    protected $serviceTag = 'shipping_method.calculator';
}
