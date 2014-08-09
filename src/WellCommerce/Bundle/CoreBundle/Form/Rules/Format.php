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

use WellCommerce\Bundle\CoreBundle\Form\AbstractRule;

/**
 * Class Format
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Rules
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Format extends AbstractRule
{
    protected $_format;

    public function __construct($errorMsg, $format)
    {
        parent::__construct($errorMsg);
        $this->_format = $format;
    }

    public function checkValue($value)
    {
        if (strlen($value) == 0) {
            return true;
        }

        return (preg_match($this->_format, $value) == 1);
    }

    public function render()
    {
        $format   = addslashes($this->_format);
        $errorMsg = addslashes($this->_errorMsg);

        return "{sType: '{$this->getType()}', sErrorMessage: '{$errorMsg}', sFormat: '{$format}'}";
    }

}
