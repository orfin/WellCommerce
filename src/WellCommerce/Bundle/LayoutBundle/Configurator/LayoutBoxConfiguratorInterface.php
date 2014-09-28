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

namespace WellCommerce\Bundle\LayoutBundle;

use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;

/**
 * Interface LayoutBoxConfiguratorInterface
 *
 * @package WellCommerce\Bundle\LayoutBundle
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LayoutBoxConfiguratorInterface
{
    /**
     * Adds form fields required to configure the layout box
     *
     * @param FormBuilderInterface $builder
     *
     * @return void
     */
    public function addFormFields(FormBuilderInterface $builder);
} 