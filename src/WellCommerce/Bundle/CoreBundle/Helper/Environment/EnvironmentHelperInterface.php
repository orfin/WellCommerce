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
     * Returns fully qualified command
     *
     * @param array $arguments
     *
     * @return string
     */
    public function getConsoleCommand(array $arguments);

    /**
     * Returns free port
     *
     * @return int
     */
    public function getFreePort();
}