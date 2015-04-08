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

use Devristo\Phpws\Server\WebSocketServer;
use React\ChildProcess\Process;
use React\EventLoop\Factory;
use React\EventLoop\Timer\Timer;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\Kernel;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

/**
 * Class InstallCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class InstallCommand extends AbstractPackageCommand
{
    protected $started;

    protected $buffer;

    protected function configure()
    {
        parent::configure();
        $this->setDescription('Install WellCommerce package');
        $this->setName('wellcommerce:package:install');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper  = $this->getContainer()->get('environment_helper');
        $port    = $input->getOption('port');
        $package = $this->getPackageInformation($input->getOption('package'));
        $loop    = Factory::create();
        $writer  = new Stream("php://output");
        $logger  = new Logger();
        $logger->addWriter($writer);

        $server        = new WebSocketServer("tcp://0.0.0.0:{$port}", $loop, $logger);
        $cwd           = $helper->getCwd();
        $command       = 'php -d display_errors=0 composer.phar require ' . $package . ':dev-master -v';
        $process       = new Process($command, $cwd);
        $this->started = false;

        $loop->addPeriodicTimer(1, function (Timer $timer) use ($output, $server, $process, $output, $port) {
            $connections = $server->getConnections();

            if ($this->started && 0 === (int)$process->isRunning()) {
                exit(127);
            }

            if ($connections->count()) {

                if (!$process->isRunning()) {
                    $process->start($timer->getLoop());
                    $this->started = true;
                    $version       = Kernel::VERSION;
                    $this->buffer .= '<strong>Started WebSocketServer on port: </strong>' . $port . PHP_EOL;
                    $this->buffer .= '<strong>Symfony2 version: </strong>' . $version . PHP_EOL;
                    $this->buffer .= '<strong>PHP version: </strong>' . phpversion() . PHP_EOL;
                    $info = $this->processOutput($this->buffer);
                    foreach ($connections as $client) {
                        $client->sendString($info);
                    }
                }

                $callable = function ($output) use ($connections, $process) {
                    $this->buffer .= $output;
                    $info = $this->processOutput($this->buffer);
                    foreach ($connections as $client) {
                        $client->sendString($info);
                    }
                };

                $process->stdin->on('data', $callable);
                $process->stdout->on('data', $callable);
                $process->stderr->on('data', $callable);
            }
        });

        $server->bind();
        $loop->run();

    }
}
