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

namespace WellCommerce\Core\DataGrid\Configuration\EventHandler;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Interface EventHandlerInterface
 *
 * @package WellCommerce\Core\DataGrid\Configuration\EventHandler
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface EventHandlerInterface
{
    /**
     * Returns function name
     *
     * @return string
     */
    public function getFunctionName();

    /**
     * Configures event options
     *
     * @param OptionsResolverInterface $resolver
     *
     * @return mixed
     */
    public function configureOptions(OptionsResolverInterface $resolver);

    /**
     * Returns template javascript used in DataGrid renderer
     *
     * @return string
     */
    public function getJavascriptFunction();
}