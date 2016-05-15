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

namespace WellCommerce\Bundle\DistributionBundle\Console\Action;

/**
 * Class ReindexAction
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ReindexAction implements ConsoleActionInterface
{
    public function getCommandsToExecute()
    {
        return [
            'wellcommerce:search:reindex' => [
                '--index'      => 'product',
                '--batch_size' => 10
            ]
        ];
    }
}
