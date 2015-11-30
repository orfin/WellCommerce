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

namespace WellCommerce\Bundle\AppBundle\Exception;

/**
 * Class AttributeGroupNotFoundException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeGroupNotFoundException extends \InvalidArgumentException
{
    public function __construct($id)
    {
        $message = sprintf('Attribute group "%s" was not found', $id);
        parent::__construct($message);
    }
}
