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

namespace WellCommerce\Bundle\CoreBundle\Helper\Environment;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class EnvironmentHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class EnvironmentHelper implements EnvironmentHelperInterface
{
    const DEFAULT_PROCESS_TIMEOUT = 360;

    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * Constructor
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
    public function getProcess(array $arguments, $timeout = self::DEFAULT_PROCESS_TIMEOUT)
    {
        $command = $this->getProcessBuilder($arguments, $timeout)->getProcess()->getCommandLine();
        $process = new Process($command, $this->getCwd());
        $process->setTimeout($timeout);

        return $process;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhpBinary()
    {
        $binaryPath = $this->kernel->getContainer()->getParameter('php_binary_path');

        if (null === $binaryPath) {
            $process = new Process('whereis php');
            $process->run();
            $output = $process->getOutput();
            $lines  = explode(PHP_EOL, $output);
            if (count($lines) > 0) {
                $binaryPath = current($lines);
            }
        }

        return $binaryPath;
    }


    /**
     * {@inheritdoc}
     */
    public function getCwd()
    {
        return $this->kernel->getRootDir() . '/../';
    }

    /**
     * {@inheritdoc}
     */
    public function getFreePort()
    {
        return rand(4444, 65525);
    }

    /**
     * {@inheritdoc}
     */
    public function getProcessBuilder(array $arguments, $timeout = self::DEFAULT_PROCESS_TIMEOUT)
    {
        $builder = new ProcessBuilder();
        $builder->setPrefix($this->getPhpBinary());
        $builder->setWorkingDirectory($this->getCwd());
        $builder->setArguments($arguments);
        $builder->setTimeout($timeout);
        $builder->inheritEnvironmentVariables(true);

        return $builder;
    }

    /**
     * {@inheritdoc}
     */
    public function getComposerPhar()
    {
        return 'composer.phar';
    }
}

