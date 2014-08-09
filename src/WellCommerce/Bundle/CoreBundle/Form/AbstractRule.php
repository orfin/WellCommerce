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

namespace WellCommerce\Bundle\CoreBundle\Form;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Class AbstractRule
 *
 * @package WellCommerce\Bundle\CoreBundle\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractRule extends ContainerAware
{
    protected $_errorMsg;
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
        return $this->_errorMsg;
    }

    public function render()
    {
        $errorMsg = addslashes($this->_errorMsg);

        return "{sType: '{$this->getType()}', sErrorMessage: '{$errorMsg}'}";
    }
}
