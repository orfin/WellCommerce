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

namespace WellCommerce\Bundle\DistributionBundle\Console;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use WellCommerce\Bundle\DistributionBundle\Console\Action\ConsoleActionInterface;

/**
 * Class ConsoleActionExecutor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ConsoleActionExecutor implements ConsoleActionExecutorInterface
{
    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @var Application
     */
    protected $application;

    /**
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    protected $output;

    /**
     * ConsoleActionExecutor constructor.
     *
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(array $actions = [], ConsoleOutputInterface $output = null)
    {
        $this->application = new Application($this->kernel);
        $this->initOutput($output);

        foreach ($actions as $action) {
            $this->runAction($action);
        }
    }

    /**
     * @param ConsoleOutputInterface|null $output
     */
    protected function initOutput(ConsoleOutputInterface $output = null)
    {
        if (null === $output) {
            $this->output = ('cli' === PHP_SAPI) ? new ConsoleOutput() : new NullOutput();
        } else {
            $this->output = $output;
        }
    }

    /**
     * @param ConsoleActionInterface $action
     */
    protected function runAction(ConsoleActionInterface $action)
    {
        $commands = $action->getCommandsToExecute();
        foreach ($commands as $command => $options) {
            $arguments = array_merge(['command' => $command], $options);
            $this->runCommand($arguments);
        }
    }

    /**
     * Executes a single command
     *
     * @param Application     $application
     * @param OutputInterface $output
     * @param array           $arguments
     *
     * @return int
     */
    protected function runCommand(array $arguments)
    {
        $input = new ArrayInput($arguments);
        $input->setInteractive(false);

        return $this->application->doRun($input, $this->output);
    }
}
