<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 06.04.15
 * Time: 11:01
 */

namespace WellCommerce\Bundle\CoreBundle\Helper\Environment;


use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

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
    public function killProcess($pid)
    {
        $process = new Process("kill  {$pid}");
        $process->run();
        echo $process->getOutput();
    }

    /**
     * {@inheritdoc}
     */
    public function getFreePort()
    {
        return rand(4444, 65525);
    }
}