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

namespace WellCommerce\Bundle\AppBundle\Kernel;

use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Interface WellCommerceKernelInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface WellCommerceKernelInterface extends KernelInterface
{
    /**
     * @return array
     */
    public function getCoreBundles();

    /**
     * @return string
     */
    public function getSourceDirectory();
}
