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

namespace WellCommerce\Bundle\ShippingBundle\Exception;

/**
 * Class ShippingSubjectAdapterNotFoundException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingSubjectAdapterNotFoundException extends \RuntimeException
{
    public function __construct($resource)
    {
        parent::__construct(sprintf('There are no adapters which can support "%"', get_class($resource)));
    }
}
