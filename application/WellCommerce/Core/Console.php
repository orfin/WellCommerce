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
namespace WellCommerce\Core;

use Symfony\Component\Console\Application;
use Symfony\Component\HttpFoundation\Request;
/**
 * Class Console
 *
 * @package WellCommerce\Core
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Console extends Application
{

    public function __construct()
    {
        parent::__construct('Welcome to WellCommerce CLI Tool', '1.0');

        $this->addCommands([
            new Console\Command\Documentation\Generate(),
            new Console\Command\Routes\Dump(),
            new Console\Command\Migration\Add(),
            new Console\Command\Migration\Up(),
            new Console\Command\Migration\Down(),
            new Console\Command\Plugin\Add(),
        ]);
    }

    /**
     * Creates ServiceContainer for using in Console applications
     *
     * @return ServiceContainer
     */
    public function getContainer()
    {
        return new ServiceContainer();
    }
}