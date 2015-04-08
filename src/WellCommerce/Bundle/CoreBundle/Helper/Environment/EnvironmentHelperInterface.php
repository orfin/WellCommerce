<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 06.04.15
 * Time: 11:01
 */

namespace WellCommerce\Bundle\CoreBundle\Helper\Environment;


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
     * Returns fully qualified command
     *
     * @param array $arguments
     *
     * @return string
     */
    public function getConsoleCommand(array $arguments);

    /**
     * Kills process by pid
     *
     * @param int $pid
     */
    public function killProcess($pid);

    /**
     * Returns free port
     *
     * @return int
     */
    public function getFreePort();
}