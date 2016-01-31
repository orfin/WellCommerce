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
 * Class InstallAction
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class InstallAction implements ConsoleActionInterface
{
    public function getCommandsToExecute()
    {
        return [
            'doctrine:database:create'    => ['--if-not-exists' => true],
            'doctrine:schema:drop'        => ['--force' => true],
            'doctrine:schema:create'      => [],
            'doctrine:fixtures:load'      => [],
            'assets:install'              => [],
            'bazinga:js-translation:dump' => [],
            'fos:js-routing:dump'         => [],
            'assetic:dump'                => [],
        ];
    }
}
