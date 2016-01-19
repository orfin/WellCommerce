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

namespace WellCommerce\Component\Form\Test;

/**
 * Class AbstractElementTestCase
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractElementTestCase extends \PHPUnit_Framework_TestCase
{
    abstract protected function getRequiredOptions();

    /**
     * @return \WellCommerce\Component\Form\Elements\ElementInterface
     */
    abstract protected function getInstance();

    public function testRequiredOptions()
    {
        $options = $this->getRequiredOptions();
        $element = $this->getInstance();
        $element->setOptions($options);

        foreach ($options as $optionName => $optionValue) {
            $this->assertEquals($optionValue, $element->getOption($optionName));
        }
    }
}
