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

namespace WellCommerce\Core\Form\Builder;

use WellCommerce\Core\AbstractComponent;
use WellCommerce\Core\Form\Conditions\ConditionInterface;
use WellCommerce\Core\Form\Elements\ElementInterface;
use WellCommerce\Core\Form\FormInterface;
use WellCommerce\Core\Model\ModelInterface;
use WellCommerce\Core\Event\FormEvent;
use WellCommerce\Core\Form\Elements;
use WellCommerce\Core\Form\Filters;
use WellCommerce\Core\Form\Rules;
use WellCommerce\Core\Form\Conditions;

/**
 * Class FormBuilder
 *
 * @package WellCommerce\Core\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FormBuilder extends AbstractComponent implements FormBuilderInterface
{
    /**
     * @var FormInterface Form instance
     */
    private $form;

    /**
     * @var array Data needed to populate the form
     */
    private $formData;

    /**
     * @var array Form options
     */
    private $options;

    /**
     * {@inheritdoc}
     */
    public function create(FormInterface $form, ModelInterface $model = null, array $options)
    {
        $this->form     = $form->buildForm($this, $options);
        $this->formData = (null === $model) ? [] : $form->prepareData($model);
        $this->dispatchEvent($this->getInitEventName($options['name']));
        $this->options = $options;
        $this->form->populate($this->formData);

        return $this;
    }

    /**
     * Triggers the event for form action
     *
     * @param       $eventName
     * @param array $data
     * @param       $id
     */
    private function dispatchEvent($eventName)
    {
        $event = new FormEvent($this);
        $this->getDispatcher()->dispatch($eventName, $event);
    }

    /**
     * Returns init event name
     *
     * @param $formName
     *
     * @return string
     */
    private function getInitEventName($formName)
    {
        return sprintf('%s.%s', $formName, FormBuilderInterface::FORM_INIT_EVENT);
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormData()
    {
        return $this->formData;
    }

    /**
     * {@inheritdoc}
     */
    public function setFormData(array $data)
    {
        $this->formData = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function addForm(array $options)
    {
        return new Elements\Form($options);
    }

    /**
     * {@inheritdoc}
     */
    public function addFieldset(array $options)
    {
        return new Elements\Fieldset($options);
    }

    /**
     * {@inheritdoc}
     */
    public function addFieldsetRepeatable(array $options)
    {
        return new Elements\FieldsetRepeatable($options);
    }

    /**
     * {@inheritdoc}
     */
    public function addLayoutBoxesList(array $options)
    {
        return new Elements\LayoutBoxesList($options);
    }

    /**
     * {@inheritdoc}
     */
    public function addFieldsetLanguage(array $options)
    {
        $options['languages'] = $this->getLanguages();

        return new Elements\FieldsetLanguage($options);
    }

    /**
     * {@inheritdoc}
     */
    public function addImage($options)
    {
        $options['file_types_description'] = $this->trans('Files description');

        return new Elements\Image($options, $this->container);
    }

    /**
     * {@inheritdoc}
     */
    public function addLocalFile($options)
    {
        $options['file_types_description'] = $this->trans('Files description');

        return new Elements\LocalFile($options, $this->container);
    }

    /**
     * {@inheritdoc}
     */
    public function addTip($options)
    {
        return new Elements\Tip($options);
    }

    /**
     * {@inheritdoc}
     */
    public function addTextField(array $options)
    {
        return new Elements\TextField($options);
    }

    /**
     * {@inheritdoc}
     */
    public function addPassword(array $options)
    {
        return new Elements\Password($options);
    }

    /**
     * {@inheritdoc}
     */
    public function addSubmitButton(array $options)
    {
        return new Elements\Submit($options);
    }


    /**
     * {@inheritdoc}
     */
    public function addTextArea(array $options)
    {
        return new Elements\Textarea($options);
    }

    /**
     * {@inheritdoc}
     */
    public function addRichTextEditor(array $options)
    {
        return new Elements\RichTextEditor($options);
    }

    /**
     * {@inheritdoc}
     */
    public function addShopSelector(array $options)
    {
        return new Elements\ShopSelector($options, $this->get('company.repository'));
    }

    /**
     * {@inheritdoc}
     */
    public function addSelect(array $options)
    {
        return new Elements\Select($options);
    }

    /**
     * {@inheritdoc}
     */
    public function addMultiSelect(array $options)
    {
        return new Elements\MultiSelect($options);
    }

    /**
     * {@inheritdoc}
     */
    public function addCheckBox(array $options)
    {
        return new Elements\Checkbox($options);
    }

    /**
     * {@inheritdoc}
     */
    public function addStaticText(array $options)
    {
        return new Elements\StaticText($options);
    }

    /**
     * {@inheritdoc}
     */
    public function addAttributeEditor(array $options)
    {
        return new Elements\AttributeEditor($options, $this->get('attribute.repository'), $this->get('xajax_manager'));
    }

    /**
     * {@inheritdoc}
     */
    public function addPrice(array $options)
    {
        return new Elements\Price($options);
    }

    /**
     * {@inheritdoc}
     */
    public function addFilterCommaToDotChanger()
    {
        return new Filters\CommaToDotChanger();
    }

    /**
     * {@inheritdoc}
     */
    public function addFilterNoCode()
    {
        return new Filters\NoCode();
    }

    /**
     * {@inheritdoc}
     */
    public function addFilterTrim()
    {
        return new Filters\Trim();
    }

    /**
     * {@inheritdoc}
     */
    public function addFilterSecure()
    {
        return new Filters\Secure();
    }

    /**
     * {@inheritdoc}
     */
    public function addRuleFormat($errorMessage, $pattern)
    {
        return new Rules\Format($errorMessage, $pattern);
    }

    /**
     * {@inheritdoc}
     */
    public function addRuleEmail($errorMessage)
    {
        return new Rules\Email($errorMessage);
    }

    /**
     * {@inheritdoc}
     */
    public function addRuleCustom($errorMessage, \Closure $function, array $params = [])
    {
        return new Rules\Custom($errorMessage, $function, $params, $this->container);
    }

    /**
     * {@inheritdoc}
     */
    public function addRuleRequired($errorMessage)
    {
        return new Rules\Required($errorMessage);
    }

    /**
     * {@inheritdoc}
     */
    public function addRuleUnique($errorMessage, array $options)
    {
        return new Rules\Unique($errorMessage, $options, $this->container);
    }

    /**
     * {@inheritdoc}
     */
    public function addRuleLanguageUnique($errorMessage, array $options)
    {
        return new Rules\LanguageUnique($errorMessage, $options, $this->container);
    }

    /**
     * {@inheritdoc}
     */
    public function makeOptions($options, $appendDefaultValue = false)
    {
        if (true === $appendDefaultValue) {
            $options['0'] = $this->trans('Choose option');
        }

        ksort($options);

        return Option::Make($options);
    }

    /**
     * {@inheritdoc}
     */
    public function addTree(array $options)
    {
        return new Elements\Tree($options, $this->container);
    }

    /**
     * {@inheritdoc}
     */
    public function addSortableList(array $options)
    {
        return new Elements\SortableList($options, $this->container);
    }

    /**
     * {@inheritdoc}
     */
    public function addRangeEditor(array $options)
    {
        $options['prefixes'] = [
            $this->trans('net'),
            $this->trans('gross')
        ];

        return new Elements\RangeEditor($options, $this->get('tax.repository'));
    }

    /**
     * {@inheritdoc}
     */
    public function addDependency($type, ElementInterface $element, ConditionInterface $condition, $argument)
    {
        return new Dependency($type, $element, $condition, $argument, $this->container);
    }
}