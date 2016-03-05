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

namespace WellCommerce\Bundle\DistributionBundle\Command\Package;

use Devristo\Phpws\Server\WebSocketServer;
use React\ChildProcess\Process;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use React\EventLoop\Timer\Timer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\Kernel;
use WellCommerce\Bundle\DistributionBundle\Entity\PackageInterface;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

/**
 * Class AbstractCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractPackageCommand extends ContainerAwareCommand
{
    const LOOP_TIMER_PERIOD = 1;

    /**
     * @var string
     */
    protected $composerOperation = 'update';

    /**
     * @var string
     */
    protected $buffer;

    protected function configure()
    {
        $this->addOption('port', null, InputOption::VALUE_REQUIRED, 'On which port start websocket server');
        $this->addOption('package', null, InputOption::VALUE_REQUIRED, 'Name of the package');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $arguments = $this->getCommandArguments($input);
        $builder   = $this->getEnvironmentHelper()->getProcessBuilder($arguments);
        $command   = $builder->getProcess()->getCommandLine();
        $loop      = Factory::create();
        $process   = new Process($command, $this->getEnvironmentHelper()->getCwd());
        $port      = (int)$input->getOption('port');
        $server    = $this->initializeServer($loop, $port);
        $started   = false;

        $this->addEnvironmentInfo($port, $command);

        $loop->addPeriodicTimer(self::LOOP_TIMER_PERIOD,
            function (Timer $timer) use ($output, $process, $server, &$started) {
                $clients = $server->getConnections();

                if (true === $started && false === $process->isRunning()) {
                    exit($process->getExitCode());
                }

                if ($clients->count()) {

                    if (!$process->isRunning()) {
                        $process->start($timer->getLoop());
                        $started = true;
                        $this->broadcastToClients($clients);
                    }

                    $callable = function ($output) use ($clients) {
                        $this->buffer .= $output;
                        $this->broadcastToClients($clients);
                    };

                    $process->stdin->on('data', $callable);
                    $process->stdout->on('data', $callable);
                    $process->stderr->on('data', $callable);
                }
            });

        $server->bind();
        $loop->run();
    }

    /**
     * Returns command arguments used in ProcessBuilder
     *
     * @param InputInterface $input
     *
     * @return array
     */
    protected function getCommandArguments(InputInterface $input)
    {
        $package = $this->getPackageInformation($input->getOption('package'));

        return [
            $this->getComposer(),
            $this->composerOperation,
            $package,
        ];
    }

    /**
     * Returns package information by identifier
     *
     * @param int $id Package identifier
     *
     * @return string
     */
    protected function getPackageInformation($id)
    {
        $package = $this->getContainer()->get('package.repository')->find($id);
        if (!$package instanceof PackageInterface) {
            throw new \InvalidArgumentException(sprintf('Package "%s" not found', $id));
        }

        return $package->getFullName();
    }

    /**
     * Returns composer filename
     *
     * @return string
     */
    protected function getComposer()
    {
        return $this->getEnvironmentHelper()->getComposerPhar();
    }

    /**
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Environment\EnvironmentHelper
     */
    protected function getEnvironmentHelper()
    {
        return $this->getContainer()->get('environment_helper');
    }

    /**
     * Initializes web-socket server
     *
     * @param LoopInterface $loop
     * @param int           $port
     *
     * @return WebSocketServer
     */
    protected function initializeServer(LoopInterface $loop, $port)
    {
        $writer = new Stream("php://output");
        $logger = new Logger();
        $logger->addWriter($writer);

        return new WebSocketServer("tcp://0.0.0.0:{$port}", $loop, $logger);
    }

    /**
     * Adds additional environment information to buffer
     *
     * @param int    $port
     * @param string $command
     */
    protected function addEnvironmentInfo($port, $command)
    {
        $translator = $this->getContainer()->get('translator');

        $info = [
            $translator->trans('environment.server.port')     => $port,
            $translator->trans('environment.console.command') => $command,
            $translator->trans('environment.symfony.version') => Kernel::VERSION,
            $translator->trans('environment.php.version')     => phpversion(),
        ];

        foreach ($info as $phrase => $value) {
            $this->buffer .= sprintf('<strong>%s: </strong>%s%s', $phrase, $value, PHP_EOL);
        }
    }

    /**
     * Sends processed output to all connected clients
     */
    protected function broadcastToClients(\SplObjectStorage $clients)
    {
        foreach ($clients as $client) {
            $client->sendString($this->processOutput());
        }
    }

    /**
     * Processes output
     *
     * @return string
     */
    protected function processOutput()
    {
        $lines = explode(PHP_EOL, $this->buffer);

        return implode('<br />', array_unique($lines));
    }

}
