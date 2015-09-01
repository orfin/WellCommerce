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

namespace WellCommerce\Bundle\CoreBundle\Test\Form;

use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;

/**
 * Class AbstractDataGridTestCase
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractFormBuilderTestCase extends AbstractTestCase
{
    /**
     * @return null|\WellCommerce\Bundle\FormBundle\Builder\FormBuilderInterface
     */
    protected function get()
    {
        return null;
    }

    abstract protected function getSampleFormModelData();

    public function testFormBuilderServiceIsCreated()
    {
        $formBuilder = $this->get();

        if (null !== $formBuilder) {
            $this->assertInstanceOf('WellCommerce\Bundle\FormBundle\Builder\FormBuilderInterface', $formBuilder);
        }
    }

    public function testFormIsCreated()
    {
        $formBuilder = $this->get();

        if (null !== $formBuilder) {
            $form = $formBuilder->createForm([
                'name' => 'test'
            ], null);

            $this->assertInstanceOf('WellCommerce\Bundle\FormBundle\Elements\FormInterface', $form);
        }
    }

    public function testFormIsAbleToReturnDefaultModelData()
    {
        $formBuilder = $this->get();

        if (null !== $formBuilder) {
            $sample = $this->getSampleFormModelData();

            $form = $formBuilder->createForm([
                'name' => 'test'
            ], $sample);

            $this->assertEquals($sample, $form->getModelData());
        }
    }

    public function testFormHasNonEmptyElementsCollection()
    {
        $formBuilder = $this->get();

        if (null !== $formBuilder) {
            $sample = $this->getSampleFormModelData();

            $form = $formBuilder->createForm([
                'name' => 'test'
            ], $sample);

            $this->assertGreaterThan(0, $form->getChildren()->count());
        }
    }
}
