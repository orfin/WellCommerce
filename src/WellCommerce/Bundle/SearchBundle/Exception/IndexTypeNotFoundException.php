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

namespace WellCommerce\Bundle\SearchBundle\Exception;

/**
 * Class IndexTypeNotFoundException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class IndexTypeNotFoundException extends \InvalidArgumentException
{
    public function __construct(string $indexType, array $availableTypes)
    {
        $message = sprintf(
            'Given index type "%s" was not found. Available types: %s',
            $indexType,
            implode(',', $availableTypes)
        );

        parent::__construct($message);
    }
}
