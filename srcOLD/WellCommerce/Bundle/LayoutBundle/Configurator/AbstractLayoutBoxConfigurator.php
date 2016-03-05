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

namespace WellCommerce\Bundle\LayoutBundle\Configurator;

use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\CoreBundle\Helper\Translator\TranslatorHelperInterface;
use WellCommerce\Component\Form\Conditions\Equals;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\FormBuilderInterface;

/**
 * Class AbstractLayoutBoxConfigurator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractLayoutBoxConfigurator extends AbstractContainerAware implements LayoutBoxConfiguratorInterface
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $controllerService;

    /**
     * @var TranslatorHelperInterface
     */
    protected $translatorHelper;

    /**
     * Constructor
     *
     * @param string                    $type
     * @param string                    $controllerService
     * @param TranslatorHelperInterface $translatorHelper
     */
    public function __construct($type, $controllerService, TranslatorHelperInterface $translatorHelper)
    {
        $this->type              = $type;
        $this->controllerService = $controllerService;
        $this->translatorHelper  = $translatorHelper;
    }

    /**
     * @return \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected function getPropertyAccessor()
    {
        return PropertyAccess::createPropertyAccessor();
    }

    /**
     * {@inheritdoc}
     */
    public function getControllerService()
    {
        return $this->controllerService;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function addFormFields(FormBuilderInterface $builder, FormInterface $form, $defaults)
    {
        $fieldset = $this->getFieldset($builder, $form);

        $fieldset->addChild($builder->getElement('tip', [
            'tip' => $this->trans('layout_box.configuration')
        ]));

        return $fieldset;
    }

    /**
     * {@inheritdoc}
     */
    protected function getFieldset(FormBuilderInterface $builder, FormInterface $form)
    {
        $boxTypeSelect = $this->getBoxTypeSelect($form);
        $boxTypeSelect->addOptionToSelect($this->type, $this->type);

        $fieldset = $form->addChild($builder->getElement('nested_fieldset', [
            'name'         => $this->getType(),
            'label'        => $this->trans('layout_box.label.settings'),
            'dependencies' => [
                $builder->getDependency('show', [
                    'field'     => $boxTypeSelect,
                    'condition' => new Equals($this->type),
                    'form'      => $form
                ]),
            ]
        ]));

        return $fieldset;
    }

    /**
     * @param FormInterface $form
     *
     * @return \WellCommerce\Component\Form\Elements\Optioned\Select
     */
    protected function getBoxTypeSelect(FormInterface $form)
    {
        return $form->getChildren()->get('required_data')->getChildren()->get('boxType');
    }
}
