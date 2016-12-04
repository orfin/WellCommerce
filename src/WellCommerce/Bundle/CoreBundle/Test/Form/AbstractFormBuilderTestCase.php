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
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Class AbstractDataGridTestCase
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractFormBuilderTestCase extends AbstractTestCase
{
    public function testFormBuilderServiceIsCreated()
    {
        $formBuilder = $this->getFormBuilderService();

        if (null !== $formBuilder) {
            $this->assertInstanceOf(FormBuilderInterface::class, $formBuilder);
        }
    }

    /**
     * @return null|\WellCommerce\Component\Form\FormBuilderInterface
     */
    protected function getFormBuilderService()
    {
        return null;
    }

    public function testFormIsCreated()
    {
        $formBuilder = $this->getFormBuilderService();

        if (null !== $formBuilder) {
            $form = $formBuilder->createForm([
                'name' => 'test'
            ], $this->getDefaultFormData());

            $this->assertInstanceOf(FormInterface::class, $form);
        }
    }

    public function testFormIsAbleToReturnDefaultModelData()
    {
        $formBuilder = $this->getFormBuilderService();

        if (null !== $formBuilder) {
            $sample = $this->getDefaultFormData();

            $form = $formBuilder->createForm([
                'name' => 'test'
            ], $sample);

            $this->assertEquals($sample, $form->getModelData());
        }
    }
    
    abstract protected function getDefaultFormData();

    public function testFormHasNonEmptyElementsCollection()
    {
        $formBuilder = $this->getFormBuilderService();

        if (null !== $formBuilder) {
            $sample = $this->getDefaultFormData();

            $form = $formBuilder->createForm([
                'name' => 'test'
            ], $sample);

            $this->assertGreaterThan(0, $form->getChildren()->count());
        }
    }
}
