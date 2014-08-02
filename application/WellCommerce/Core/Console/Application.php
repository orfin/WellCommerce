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

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WellCommerce\Core\Console\Command\Install\Database;
use WellCommerce\Core\Console\Command\Migration\Add;
use WellCommerce\Core\Console\Command\Migration\Up;

/**
 * Class Console
 *
 * @package WellCommerce\Core
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Application extends BaseApplication
{
    private $application;

    public function __construct(\WellCommerce\Core\Application $application)
    {
        $this->application = $application;
        parent::__construct('Welcome to DoItWell - WellCommerce console application', '1.0');
    }

    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $this->application->boot();

        $container = $this->application->getContainer();

        $this->setDispatcher($container->get('event_dispatcher'));

        return parent::doRun($input, $output);
    }
}