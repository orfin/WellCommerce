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


class LayoutBoxNotFoundException extends \RuntimeException
{
    /**
     * Constructor
     *
     * @param string $id LayoutBox identifier
     */
    public function __construct($id)
    {
        parent::__construct(sprintf('LayoutBox "%s" was not found', $id));
    }
}
