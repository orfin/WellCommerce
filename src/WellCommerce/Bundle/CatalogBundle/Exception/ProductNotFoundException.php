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

namespace WellCommerce\Bundle\CatalogBundle\Exception;

/**
 * Class ProductNotFoundException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductNotFoundException extends \RuntimeException
{
    /**
     * Constructor
     *
     * @param int $id Product identifier
     */
    public function __construct($id)
    {
        parent::__construct(sprintf('Product with ID "%s" was not found.', $id));
    }
}
