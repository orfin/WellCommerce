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
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WellCommerce\Bundle\DistributionBundle\Console\Action\InstallAction;
use WellCommerce\Bundle\DistributionBundle\Console\ConsoleActionExecutor;

/**
 * Class InstallCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class InstallCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Installs WellCommerce');
        $this->setName('wellcommerce:install');
    }

    /**
     * Executes the command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $executor = new ConsoleActionExecutor($this->getApplication(), $output);
        $executor->execute(new InstallAction());
    }
}
