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
    public function getConsoleCommand(array $arguments)
    {
        $builder = new ProcessBuilder();
        $builder->setPrefix($this->getPhpBinary());
        $builder->setWorkingDirectory($this->getCwd());

        return $builder
            ->setArguments($arguments)
            ->getProcess()
            ->getCommandLine();
    }

    /**
     * {@inheritdoc}
     */
    public function getPhpBinary()
    {
        $possibleBinaryLocations = [
            PHP_BINDIR . '/php',
            PHP_BINDIR . '/php-cli.exe',
            PHP_BINDIR . '/php.exe'
        ];

        foreach ($possibleBinaryLocations as $binary) {
            if (is_readable($binary)) {
                return $binary;
                break;
            }
        }

        throw new \RuntimeException('Path to PHP binary not found');
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
}
