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

namespace WellCommerce\Bundle\SmugglerBundle\Command\Server;

use Devristo\Phpws\Server\WebSocketServer;
use React\ChildProcess\Process;
use React\EventLoop\Timer\Timer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

/**
 * Class InstallCommand
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class RunCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setDescription('Run Ratchet')
            ->setName('wellcommerce:smuggler:run')
            ->addArgument(
                'port',
                InputArgument::REQUIRED,
                'On which port should Smuggler listen?'
            )
            ->addArgument(
                'package',
                InputArgument::REQUIRED,
                'What is the name of package?'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $port    = $input->getArgument('port');
        $package = $input->getArgument('package');
        $loop    = \React\EventLoop\Factory::create();
        $writer  = new Stream("php://output");
        $logger  = new Logger();
        $logger->addWriter($writer);

        $server    = new WebSocketServer("tcp://0.0.0.0:{$port}", $loop, $logger);
        $helper    = $this->getContainer()->get('environment_helper');
        $cwd       = $helper->getCwd();
        $command   = $helper->getPhpCommand("composer.phar require {$package}:0.1.*@dev");
        $process   = new Process($command, $cwd);
        $buffer    = '';
        $iteration = 0;

        $loop->addPeriodicTimer(5, function (Timer $timer) use ($output, $server, $process, &$buffer, &$iteration) {
            $output->write('Started');
            $iteration++;
            $connections = $server->getConnections();
            if ('' === $buffer) {
                foreach ($connections as $client) {
                    $client->sendString('Initializing Composer' . str_repeat('.', $iteration));
                }
            }
            if ($connections->count()) {

                $process->start($timer->getLoop());

                $callable = function ($output) use ($connections, &$buffer) {
                    $buffer .= $output;
                    $info = $this->processOutput($buffer);
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

    protected function processOutput($output)
    {
        $lines = explode(PHP_EOL, $output);

        return implode('<br />', array_unique($lines));
    }
}