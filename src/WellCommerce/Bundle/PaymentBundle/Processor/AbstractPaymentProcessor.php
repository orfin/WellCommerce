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

use Doctrine\Common\Util\ClassUtils;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainer;
use WellCommerce\Bundle\FormBundle\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\Elements\Fieldset;
use WellCommerce\Bundle\FormBundle\Elements\Form;

/**
 * Class AbstractPaymentProcessor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractPaymentProcessor extends AbstractContainer implements PaymentMethodProcessorInterface
{
    protected $alias;

    public function getAlias()
    {
        return $this->alias;
    }
}
