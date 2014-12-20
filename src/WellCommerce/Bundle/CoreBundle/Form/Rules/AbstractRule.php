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

namespace WellCommerce\Bundle\CoreBundle\Form\Rules;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Class AbstractRule
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Rules
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractRule extends ContainerAware
{
    protected $options = [];

    public function setOptions(array $options = [])
    {
        $this->options = $options;
    }

    public function check($value)
    {
        if ($this->checkValue($value) === true) {
            return true;
        }

        return $this->getFailureMessage();
    }

    abstract protected function checkValue($value);

    public function getType()
    {
        $class = explode('\\', get_class($this));

        return strtolower(end($class));
    }

    public function getFailureMessage()
    {
        return $this->options['message'];
    }

    public function render()
    {
        $type     = $this->getType();
        $errorMsg = addslashes($this->getFailureMessage());

        return "{sType: '{$type}', sErrorMessage: '{$errorMsg}'}";
    }
}
