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
     * @return null|\WellCommerce\Component\Form\FormBuilderInterface
     */
    protected function getFormBuilderService()
    {
        return null;
    }

    /**
     * @return \WellCommerce\Bundle\AppBundle\Factory\FactoryInterface
     */
    abstract protected function getFactoryService();

    public function testFormBuilderServiceIsCreated()
    {
        $formBuilder = $this->getFormBuilderService();

        if (null !== $formBuilder) {
            $this->assertInstanceOf('WellCommerce\Component\Form\FormBuilderInterface', $formBuilder);
        }
    }

    public function testFormIsCreated()
    {
        $formBuilder = $this->getFormBuilderService();

        if (null !== $formBuilder) {
            $form = $formBuilder->createForm([
                'name' => 'test'
            ], null);

            $this->assertInstanceOf('WellCommerce\Component\Form\Elements\FormInterface', $form);
        }
    }

    public function testFormIsAbleToReturnDefaultModelData()
    {
        $formBuilder = $this->getFormBuilderService();

        if (null !== $formBuilder) {
            $sample = $this->getSampleData();

            $form = $formBuilder->createForm([
                'name' => 'test'
            ], $sample);

            $this->assertEquals($sample, $form->getModelData());
        }
    }

    public function testFormHasNonEmptyElementsCollection()
    {
        $formBuilder = $this->getFormBuilderService();

        if (null !== $formBuilder) {
            $sample = $this->getSampleData();

            $form = $formBuilder->createForm([
                'name' => 'test'
            ], $sample);

            $this->assertGreaterThan(0, $form->getChildren()->count());
        }
    }

    /**
     * @return object
     */
    protected function getSampleData()
    {
        return $this->getFactoryService()->create();
    }
}
