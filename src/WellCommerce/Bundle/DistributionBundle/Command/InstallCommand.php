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

namespace WellCommerce\Bundle\DistributionBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WellCommerce\Bundle\DistributionBundle\Console\Action\InstallAssetsAction;
use WellCommerce\Bundle\DistributionBundle\Console\Action\InstallDatabaseAction;
use WellCommerce\Bundle\DistributionBundle\Console\Action\InstallFixturesAction;
use WellCommerce\Bundle\DistributionBundle\Console\Action\ReindexAction;
use WellCommerce\Bundle\DistributionBundle\Console\ConsoleActionExecutorInterface;

/**
 * Class InstallCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class InstallCommand extends Command
{
    /**
     * @var ConsoleActionExecutorInterface
     */
    protected $executor;

    /**
     * InstallCommand constructor.
     *
     * @param ConsoleActionExecutorInterface $executor
     */
    public function __construct(ConsoleActionExecutorInterface $executor)
    {
        parent::__construct();
        $this->executor = $executor;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Installs WellCommerce');
        $this->setName('wellcommerce:install');
    }

    /**
     * Executes the actions
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $actions = [
            new InstallDatabaseAction(),
            new InstallFixturesAction(),
            new ReindexAction(),
            new InstallAssetsAction()
        ];

        $this->executor->execute($actions, $output);
    }
}
