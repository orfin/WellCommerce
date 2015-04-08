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
use Packagist\Api\Client;
use React\ChildProcess\Process;
use React\EventLoop\Factory;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

/**
 * Class AbstractCommand
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractPackageCommand extends ContainerAwareCommand
{
    /**
     * @var WebSocketServer
     */
    protected $server;

    /**
     * @var string
     */
    protected $buffer;

    /**
     * @var Process
     */
    protected $process;

    protected function configure()
    {
        $this->addOption('port', null, InputOption::VALUE_REQUIRED, 'Port on which socket server should listen');
        $this->addOption('package', null, InputOption::VALUE_REQUIRED, 'Name of the package');
    }

    /**
     * Initializes ws server
     *
     * @param $port
     */
    protected function initializeServer($port)
    {
        $loop   = Factory::create();
        $writer = new Stream("php://output");
        $logger = new Logger();
        $logger->addWriter($writer);

        $this->server = new WebSocketServer("tcp://0.0.0.0:{$port}", $loop, $logger);
    }

    /**
     * Returns list of connected clients
     *
     * @return \Devristo\Phpws\Protocol\WebSocketTransportInterface[]|\SplObjectStorage
     */
    protected function getConnectedClients()
    {
        return $this->server->getConnections();
    }

    /**
     * Processes output
     *
     * @param $output
     *
     * @return string
     */
    protected function processOutput($output)
    {
        $lines = explode(PHP_EOL, $output);

        return implode('<br />', array_unique($lines));
    }

    /**
     * Returns root path of Symfony installation
     *
     * @return string
     */
    protected function getCwd()
    {
        return $this->getEnvironmentHelper()->getCwd();
    }

    /**
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Environment\EnvironmentHelper
     */
    protected function getEnvironmentHelper()
    {
        return $this->getContainer()->get('environment_helper');
    }

    /**
     * Initializes child process
     *
     * @param string $cmd
     * @param string $cwd
     */
    protected function initializeProcess($cmd, $cwd)
    {
        $this->process = new Process($cmd, $cwd);
    }

    protected function getPackageInformation($id)
    {
        $entity = $this->getContainer()->get('package.repository')->find($id);
        if (null === $entity) {
            throw new \InvalidArgumentException(sprintf('Package "%s" not found', $id));
        }

        return $entity->getFullName();
    }
}