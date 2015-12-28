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

namespace WellCommerce\Bundle\AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->getCommandsToExecute() as $command) {
            $this->executeCommand($output, $command);
        }
    }

    /**
     * @return array
     */
    protected function getCommandsToExecute()
    {
        $commands = [];

        $commands[] = ['command' => 'doctrine:database:create', '--if-not-exists' => true];
        $commands[] = ['command' => 'doctrine:schema:drop', '--force' => true];
        $commands[] = ['command' => 'doctrine:schema:create'];
        $commands[] = ['command' => 'doctrine:fixtures:load'];
        $commands[] = ['command' => 'assets:install'];
        $commands[] = ['command' => 'bazinga:js-translation:dump'];
        $commands[] = ['command' => 'fos:js-routing:dump'];
        $commands[] = ['command' => 'assetic:dump'];

        return $commands;
    }

    protected function executeCommand(OutputInterface $output, $arguments)
    {
        $app   = $this->getApplication();
        $input = new ArrayInput($arguments);
        $input->setInteractive(false);
        $returnCode = $app->doRun($input, $output);

        if ($returnCode == 0) {
            return true;
        }

        return false;
    }
}
