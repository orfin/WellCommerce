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

/**
 * Interface EnvironmentHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface EnvironmentHelperInterface
{
    /**
     * Returns the path to the binary of the current runtime
     *
     * @return string
     */
    public function getPhpBinary();

    /**
     * Returns the path to the Symfony root dir
     *
     * @return string
     */
    public function getCwd();

    /**
     * Returns process
     *
     * @param array $arguments
     * @param int   $timeout
     *
     * @return \Symfony\Component\Process\Process
     */
    public function getProcess(array $arguments, $timeout = 360);

    /**
     * Returns process builder
     *
     * @param array $arguments
     * @param int   $timeout
     *
     * @return \Symfony\Component\Process\ProcessBuilder
     */
    public function getProcessBuilder(array $arguments, $timeout);

    /**
     * Returns free port
     *
     * @return int
     */
    public function getFreePort();

    /**
     * Returns composer phar name
     *
     * @return string
     */
    public function getComposerPhar();
}
