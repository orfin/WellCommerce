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

namespace WellCommerce\Bundle\PaymentBundle\Processor;

use WellCommerce\Bundle\FormBundle\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\Elements\Fieldset;
use WellCommerce\Bundle\FormBundle\Elements\Form;

/**
 * Interface PaymentMethodProcessorInterface
 *
 * @package WellCommerce\Bundle\PaymentBundle\Processor
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentMethodProcessorInterface
{
    /**
     * Returns processor alias
     *
     * @return string
     */
    public function getAlias();

    /**
     * Returns processor name
     *
     * @return string
     */
    public function getName();
}
