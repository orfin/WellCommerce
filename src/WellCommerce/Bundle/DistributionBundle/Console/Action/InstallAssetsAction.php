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
 * Class InstallAssetsAction
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class InstallAssetsAction implements ConsoleActionInterface
{
    public function getCommandsToExecute()
    {
        return [
            'assets:install'              => [],
            'bazinga:js-translation:dump' => [],
            'fos:js-routing:dump'         => []
        ];
    }
}
