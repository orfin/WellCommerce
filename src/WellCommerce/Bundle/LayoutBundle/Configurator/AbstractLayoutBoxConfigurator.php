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
use Symfony\Component\PropertyAccess\PropertyAccessor;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\CoreBundle\Helper\Translator\TranslatorHelperInterface;
use WellCommerce\Component\Form\Conditions\Equals;
use WellCommerce\Component\Form\Elements\Fieldset\FieldsetInterface;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\Elements\Optioned\Select;
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
    public function __construct(string $type, string $controllerService, TranslatorHelperInterface $translatorHelper)
    {
        $this->type              = $type;
        $this->controllerService = $controllerService;
        $this->translatorHelper  = $translatorHelper;
    }

    /**
     * @return PropertyAccessor
     */
    protected function getPropertyAccessor() : PropertyAccessor
    {
        return PropertyAccess::createPropertyAccessor();
    }

    /**
     * {@inheritdoc}
     */
    public function getControllerService() : string
    {
        return $this->controllerService;
    }

    /**
     * {@inheritdoc}
     */
    public function getType() : string
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
    protected function getFieldset(FormBuilderInterface $builder, FormInterface $form) : FieldsetInterface
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
     * @return Select
     */
    protected function getBoxTypeSelect(FormInterface $form) : Select
    {
        return $form->getChildren()->get('required_data')->getChildren()->get('boxType');
    }
}
