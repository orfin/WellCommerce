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
 * Class ExtendDoctrineAction
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ExtendDoctrineAction implements ConsoleActionInterface
{
    public function getCommandsToExecute()
    {
        return [
            'wellcommerce:doctrine:extend-entities' => [],
            'wellcommerce:doctrine:extend-mapping'  => [],
            'doctrine:schema:update'                => ['--force' => true],
        ];
    }
}
