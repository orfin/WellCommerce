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

namespace WellCommerce\Plugin\Layout\Validator;

use Symfony\Component\Validator\Context\ExecutionContextInterface;
use WellCommerce\Core\Component\AbstractComponent;

/**
 * Class LayoutBoxValidator
 *
 * @package WellCommerce\Plugin\Layout\Validator
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxValidator extends AbstractComponent
{
    /**
     * Validates layout box params
     *
     * @param                           $object
     * @param ExecutionContextInterface $context
     */
    public static function validate($object, ExecutionContextInterface $context)
    {

    }
} 