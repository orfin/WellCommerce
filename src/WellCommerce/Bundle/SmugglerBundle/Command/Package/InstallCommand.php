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

namespace WellCommerce\Bundle\SmugglerBundle\Command\Package;

use React\ChildProcess\Process;
use React\EventLoop\Factory;
use React\EventLoop\Timer\Timer;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class InstallCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class InstallCommand extends AbstractPackageCommand
{
    /**
     * @var \WellCommerce\Bundle\CoreBundle\Helper\Environment\EnvironmentHelperInterface
     */
    protected $helper;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();
        $this->setDescription('Install WellCommerce package');
        $this->setName('wellcommerce:package:install');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->helper = $this->getContainer()->get('environment_helper');
        $this->port   = $input->getOption('port');
        $package      = $this->getPackageInformation($input->getOption('package'));
        $loop         = Factory::create();

        $this->initializeServer();

        $cwd           = $this->helper->getCwd();
        $command       = 'php -d display_errors=0 composer.phar require ' . $package . ' -v';
        $process       = new Process($command, $cwd);
        $this->started = false;

        $loop->addPeriodicTimer(1, function (Timer $timer) use ($process, $output) {

            if ($this->started && 0 === (int)$process->isRunning()) {
                exit(127);
            }

            if ($this->getConnectedClients()->count()) {

                if (!$process->isRunning()) {
                    $process->start($timer->getLoop());
                    $this->started = true;
                    $this->addEnvironmentInfo();
                    $this->broadcastToClients();
                }

                $callable = function ($output) {
                    $this->buffer .= $output;
                    $this->broadcastToClients();
                };

                $process->stdin->on('data', $callable);
                $process->stdout->on('data', $callable);
                $process->stderr->on('data', $callable);
            }
        });

        $this->server->bind();
        $loop->run();
    }
}

