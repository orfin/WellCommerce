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
namespace WellCommerce\Core\Console;

use Symfony\Component\Console\Application;
use WellCommerce\Core\DependencyInjection\ServiceContainer;

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
        parent::__construct('Welcome to DoItWell', '1.0');

        $this->addCommands([
            new Command\Documentation\Generate(),
            new Command\Migration\Add(),
            new Command\Migration\Up(),
            new Command\Migration\Down(),
            new Command\Plugin\Add(),
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