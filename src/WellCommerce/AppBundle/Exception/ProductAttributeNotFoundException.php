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

namespace WellCommerce\AppBundle\Exception;

/**
 * Class ProductAttributeNotFoundException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductAttributeNotFoundException extends \RuntimeException
{
    /**
     * Constructor
     *
     * @param int $id
     */
    public function __construct($id)
    {
        parent::__construct(sprintf('Product attribute with ID "%s" was not found.', $id));
    }
}
