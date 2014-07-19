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

namespace WellCommerce\AddressType\Type;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Interface AdressTypeInterface
 *
 * @package WellCommerce\AddressType\Type
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AddressTypeInterface
{
    /**
     * Returns address type alias
     *
     * @return mixed
     */
    public function getAlias();

    /**
     * Configures address type options
     *
     * @param OptionsResolverInterface $resolver
     *
     * @return mixed
     */
    public function configure(OptionsResolverInterface $resolver);

    /**
     * Returns an array containing all fields
     *
     * @return mixed
     */
    public function getFields();

    /**
     * Validates address
     *
     * @return mixed
     */
    public function validate();
} 