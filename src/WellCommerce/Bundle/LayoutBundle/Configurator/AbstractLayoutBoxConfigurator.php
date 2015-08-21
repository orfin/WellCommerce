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

use Symfony\Component\DependencyInjection\ContainerAware;
use WellCommerce\Bundle\CoreBundle\Helper\Translator\TranslatorHelperInterface;
use WellCommerce\Bundle\FormBundle\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\Conditions\Equals;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

/**
 * Class AbstractLayoutBoxConfigurator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractLayoutBoxConfigurator implements LayoutBoxConfiguratorInterface
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
            'tip' => '<p>' . $this->trans('layout_box.configuration') . '</p>'
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
     * @return \WellCommerce\Bundle\FormBundle\Elements\Optioned\Select
     */
    protected function getBoxTypeSelect(FormInterface $form)
    {
        return $form->getChildren()->get('required_data')->getChildren()->get('boxType');
    }

    protected function trans($message)
    {
        return $this->translatorHelper->trans($message);
    }
}
